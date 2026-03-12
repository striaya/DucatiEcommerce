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

    public function adminIndex(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products   = $query->latest()->paginate(20);
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:200',
            'category_id'     => 'required|exists:categories,id',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'slug'            => 'nullable|string|unique:products,slug',
            'engine_cc'       => 'nullable|integer',
            'power_hp'        => 'nullable|numeric',
            'credit_eligible' => 'boolean',
            'is_active'       => 'boolean',
        ]);

        Product::create($request->only([
            'name',
            'slug',
            'category_id',
            'description',
            'price',
            'stock',
            'image_url',
            'engine_cc',
            'power_hp',
            'credit_eligible',
            'is_active'
        ]));

        return redirect('/admin/products')->with('success', 'Motor berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $product->update($request->only([
            'name',
            'slug',
            'category_id',
            'description',
            'price',
            'stock',
            'image_url',
            'engine_cc',
            'power_hp',
            'credit_eligible',
            'is_active'
        ]));

        return redirect('/admin/products')->with('success', 'Motor berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        Product::findOrFail($id)->delete();
        return redirect('/admin/products')->with('success', 'Motor berhasil dihapus.');
    }
}
