<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payments'])
            ->latest('ordered_at')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payments', 'address', 'creditApplication.installmentSchedules'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang kamu kosong.');
        }

        $addresses  = UserAddress::where('user_id', Auth::id())->get();
        $grandTotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

        return view('orders.checkout', compact('cartItems', 'addresses', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id'    => 'required|exists:user_addresses,id',
            'purchase_type' => 'required|in:cash,credit',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang kamu kosong.');
        }

        if ($request->purchase_type === 'credit') {
            $notEligible = $cartItems->filter(fn($item) => !$item->product->credit_eligible);
            if ($notEligible->isNotEmpty()) {
                return back()->with('error', 'Produk "' . $notEligible->first()->product->name . '" tidak tersedia untuk pembelian kredit.');
            }
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$item->product->name} tidak cukup.");
                }
                $subtotal += $item->product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id'       => Auth::id(),
                'address_id'    => $request->address_id,
                'order_number'  => Order::generateOrderNumber(),
                'purchase_type' => $request->purchase_type,
                'status'        => 'pending',
                'subtotal'      => $subtotal,
                'grand_total'   => $subtotal,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->product->price,
                    'total_price'  => $item->product->price * $item->quantity,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            if ($request->purchase_type === 'cash') {
                return redirect("/orders/{$order->id}/payment")->with('success', 'Order berhasil! Silakan lanjutkan pembayaran.');
            }

            return redirect("/orders/{$order->id}/credit")
                ->with('success', 'Order berhasil! Silakan ajukan kredit.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('purchase_type')) {
            $query->where('purchase_type', $request->purchase_type);
        }

        $orders = $query->latest('ordered_at')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow(int $id)
    {
        $order = Order::with(['user', 'items.product', 'payments', 'address', 'creditApplication'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        Order::findOrFail($id)->update(['status' => $request->status]);

        return back()->with('success', 'Status order diperbarui.');
    }
}
