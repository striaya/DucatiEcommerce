<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function create(int $orderId)
    {
        $order = Order::where('user_id', Auth::id())
                      ->with('items.product')
                      ->findOrFail($orderId);

        if ($order->purchase_type !== 'credit') {
            return redirect("/orders/{$orderId}")->with('error', 'Order ini bukan tipe kredit.');
        }

        if ($order->creditApplication()->exists()) {
            return redirect("/orders/{$orderId}")->with('info', 'Pengajuan kredit sudah ada.');
        }

        $providers = ['ACC', 'WOM Finance', 'BAF', 'FIF', 'Adira Finance'];
        $tenors    = [12, 24, 36, 48, 60];

        return view('credits.create', compact('order', 'providers', 'tenors'));
    }

    public function store(Request $request, int $orderId)
    {
        $request->validate([
            'provider'          => 'required|string|max:80',
            'tenure_months'     => 'required|integer|in:12,24,36,48,60',
            'interest_rate_pct' => 'required|numeric|min:0|max:100',
            'dp_amount'         => 'required|numeric|min:0',
            'doc_ktp_url'       => 'required|url',
            'doc_slip_gaji_url' => 'nullable|url',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        $user  = Auth::user();

        if ($user->kyc_status !== 'verified') {
            return back()->with('error', 'KYC kamu belum terverifikasi. Hubungi admin.');
        }

        $calc = CreditApplication::calculateInstallment(
            vehiclePrice:    $order->grand_total,
            dpAmount:        $request->dp_amount,
            interestRatePct: $request->interest_rate_pct,
            tenureMonths:    $request->tenure_months,
        );

        DB::beginTransaction();
        try {
            CreditApplication::create([
                'order_id'            => $orderId,
                'user_id'             => Auth::id(),
                'provider'            => $request->provider,
                'tenure_months'       => $request->tenure_months,
                'interest_rate_pct'   => $request->interest_rate_pct,
                'dp_amount'           => $request->dp_amount,
                'loan_amount'         => $calc['loan_amount'],
                'monthly_installment' => $calc['monthly_installment'],
                'total_payment'       => $calc['total_payment'],
                'status'              => 'pending',
                'doc_ktp_url'         => $request->doc_ktp_url,
                'doc_slip_gaji_url'   => $request->doc_slip_gaji_url,
                'submitted_at'        => now(),
            ]);

            DB::commit();

            return redirect("/orders/{$orderId}")
                   ->with('success', 'Pengajuan kredit berhasil dikirim. Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $credits = CreditApplication::where('user_id', Auth::id())
                                    ->with(['order', 'installmentSchedules'])
                                    ->latest()
                                    ->paginate(10);

        return view('credits.index', compact('credits'));
    }

    public function show(int $id)
    {
        $credit = CreditApplication::where('user_id', Auth::id())
                                   ->with(['order.items.product', 'installmentSchedules'])
                                   ->findOrFail($id);

        return view('credits.show', compact('credit'));
    }

    public function payInstallment(Request $request, int $creditId, int $scheduleId)
    {
        $request->validate([
            'method'  => 'required|in:va_bank,credit_card,e_wallet,qris',
            'gateway' => 'required|string',
        ]);

        $credit   = CreditApplication::where('user_id', Auth::id())->findOrFail($creditId);
        $schedule = $credit->installmentSchedules()->findOrFail($scheduleId);

        if ($schedule->status === 'paid') {
            return back()->with('error', 'Cicilan ini sudah dibayar.');
        }

        DB::beginTransaction();
        try {
            $totalDue = $schedule->amount_due + $schedule->late_penalty;

            \App\Models\Payment::create([
                'order_id'        => $credit->order_id,
                'method'          => $request->method,
                'gateway'         => $request->gateway,
                'transaction_ref' => 'INST-' . strtoupper(uniqid()),
                'amount'          => $totalDue,
                'status'          => 'success',
                'paid_at'         => now(),
                'expires_at'      => now()->addHours(1),
            ]);

            $schedule->markAsPaid($totalDue);

            $allPaid = $credit->installmentSchedules()
                              ->whereNotIn('status', ['paid', 'waived'])
                              ->doesntExist();

            if ($allPaid) {
                $credit->update(['status' => 'completed']);
            }

            DB::commit();

            return back()->with('success', "Cicilan ke-{$schedule->period_number} berhasil dibayar!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function adminIndex(Request $request)
    {
        $query = CreditApplication::with(['user', 'order']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $credits = $query->latest()->paginate(20);
        return view('admin.credits.index', compact('credits'));
    }

    public function adminShow(int $id)
    {
        $credit = CreditApplication::with(['user', 'order.items.product', 'installmentSchedules'])
                                   ->findOrFail($id);

        return view('admin.credits.show', compact('credit'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,active,completed',
        ]);

        $credit = CreditApplication::findOrFail($id);

        DB::beginTransaction();
        try {
            $credit->update([
                'status'      => $request->status,
                'approved_at' => $request->status === 'approved' ? now() : $credit->approved_at,
            ]);

            if ($request->status === 'approved') {
                $credit->generateSchedules();
                $credit->order->update(['status' => 'confirmed']);
            }

            DB::commit();
            return back()->with('success', "Status kredit diubah menjadi {$request->status}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
