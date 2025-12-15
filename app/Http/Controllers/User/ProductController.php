<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product catalog
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category') && $request->category && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search && trim($request->search) != '' && $request->search != '/') {
            $searchTerm = trim($request->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('user.products.index', compact('products', 'categories'));
    }

    /**
     * Display product details
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('user.products.show', compact('product'));
    }
}
