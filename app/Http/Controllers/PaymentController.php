<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(int $orderId)
    {
        $order = Order::where('user_id', Auth::id())
                      ->with('items.product')
                      ->findOrFail($orderId);

        if ($order->isPaid()) {
            return redirect("/orders/{$orderId}")->with('info', 'Order ini sudah lunas.');
        }

        return view('payments.show', compact('order'));
    }

    public function store(Request $request, int $orderId)
    {
        $request->validate([
            'method'  => 'required|in:va_bank,credit_card,e_wallet,qris,installment',
            'gateway' => 'required|string|max:60',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        if ($order->isPaid()) {
            return redirect("/orders/{$orderId}")->with('error', 'Order ini sudah lunas.');
        }

        $payment = Payment::create([
            'order_id'        => $orderId,
            'method'          => $request->method,
            'gateway'         => $request->gateway,
            'transaction_ref' => 'DCT-TXN-' . strtoupper(uniqid()),
            'amount'          => $order->grand_total,
            'status'          => 'pending',
            'expires_at'      => now()->addHours(24),
        ]);

        $this->fillPaymentData($payment, $request->method);

        return redirect("/payments/{$payment->payment_id}")
               ->with('success', 'Pembayaran berhasil dibuat. Selesaikan sebelum expired!');
    }

    public function detail(int $id)
    {
        $payment = Payment::with('order.items.product')->findOrFail($id);

        abort_if($payment->order->user_id !== Auth::id(), 403);

        return view('payments.detail', compact('payment'));
    }

    public function confirm(int $id)
    {
        $payment = Payment::findOrFail($id);
        abort_if($payment->order->user_id !== Auth::id(), 403);

        $payment->update([
            'status'  => 'success',
            'paid_at' => now(),
        ]);

        $payment->order->update(['status' => 'confirmed']);

        return redirect("/orders/{$payment->order_id}")
               ->with('success', 'Pembayaran dikonfirmasi! Order sedang diproses.');
    }

    public function webhook(Request $request)
    {
        $ref    = $request->input('transaction_ref') ?? $request->input('external_id');
        $status = $request->input('transaction_status') ?? $request->input('status');

        $payment = Payment::where('transaction_ref', $ref)->first();
        if (!$payment) return response('not found', 404);

        $map = [
            'settlement' => 'success', 'capture' => 'success', 'PAID' => 'success',
            'pending'    => 'pending',  'PENDING' => 'pending',
            'deny'       => 'failed',   'EXPIRED' => 'failed',  'cancel' => 'failed',
        ];

        $newStatus = $map[$status] ?? 'pending';
        $payment->update([
            'status'  => $newStatus,
            'paid_at' => $newStatus === 'success' ? now() : null,
        ]);

        if ($newStatus === 'success') {
            $payment->order->update(['status' => 'confirmed']);
        }

        return response('ok', 200);
    }

    private function fillPaymentData(Payment $payment, string $method): void
    {
        match ($method) {
            'va_bank' => $payment->update([
                'va_number' => '8277' . rand(10000000000, 99999999999),
            ]),
            'qris' => $payment->update([
                'qr_code_url' => 'https://api.qris.id/qr/' . uniqid(),
            ]),
            default => null,
        };
    }
}