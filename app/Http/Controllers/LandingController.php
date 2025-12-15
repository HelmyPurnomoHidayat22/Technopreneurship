<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display landing page
     */
    public function index()
    {
        // Get featured products (latest 8)
        $featuredProducts = Product::with('category')
            ->latest()
            ->take(8)
            ->get();

        // Get all categories
        $categories = Category::withCount('products')->get();

        return view('landing', compact('featuredProducts', 'categories'));
    }
}
