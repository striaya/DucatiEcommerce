<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->boolean('credit_eligible')) {
            $query->creditEligible();
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(int $id)
    {
        $product  = Product::with(['category', 'reviews.user'])->findOrFail($id);
        $avgRating = round($product->reviews->avg('rating') ?? 0, 1);
        $related  = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)->limit(4)
            ->get();

        return view('products.show', compact('product', 'avgRating', 'related'));
    }

    public function adminIndex()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'     => 'required|exists:categories,category_id',
            'name'            => 'required|string|max:200',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'image_url'       => 'nullable|url',
            'engine_cc'       => 'nullable|integer',
            'power_hp'        => 'nullable|numeric',
            'credit_eligible' => 'boolean',
            'is_active'       => 'boolean',
        ]);

        $validated['slug']            = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['credit_eligible'] = $request->has('credit_eligible');
        $validated['is_active']       = $request->has('is_active');

        Product::create($validated);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $product   = Product::findOrFail($id);
        $validated = $request->validate([
            'category_id'     => 'required|exists:categories,category_id',
            'name'            => 'required|string|max:200',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'image_url'       => 'nullable|url',
            'engine_cc'       => 'nullable|integer',
            'power_hp'        => 'nullable|numeric',
            'credit_eligible' => 'boolean',
            'is_active'       => 'boolean',
        ]);

        $validated['credit_eligible'] = $request->has('credit_eligible');
        $validated['is_active']       = $request->has('is_active');

        $product->update($validated);

        return redirect('/admin/products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => false]);

        return redirect('/admin/products')->with('success', 'Produk dinonaktifkan.');
    }
}
