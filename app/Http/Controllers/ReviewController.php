<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id'   => 'required|exists:orders,id',
            'rating'     => 'required|integer|min:1|max:5',
            'title'      => 'nullable|string|max:150',
            'body'       => 'nullable|string',
        ]);

        $hasBought = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('items', fn($q) => $q->where('product_id', $request->product_id))
            ->exists();

        $alreadyReviewed = Review::where([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
            'order_id'   => $request->order_id,
        ])->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk produk ini.');
        }

        Review::create([
            'user_id'     => Auth::id(),
            'product_id'  => $request->product_id,
            'order_id'    => $request->order_id,
            'rating'      => $request->rating,
            'title'       => $request->title,
            'body'        => $request->body,
            'is_verified' => $hasBought,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Ulasan dihapus.');
    }
}
