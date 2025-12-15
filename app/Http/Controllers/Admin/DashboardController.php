<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalTransactions = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('amount');
        
        
        // Best selling products
        $bestSellingProducts = Product::select(
                'products.id',
                'products.title',
                'products.price',
                'products.preview_image',
                'products.category_id',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.amount) as total_revenue')
            )
            ->leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->where('orders.status', 'paid')
            ->groupBy('products.id', 'products.title', 'products.price', 'products.preview_image', 'products.category_id')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();


        return view('admin.dashboard', compact('totalUsers', 'totalTransactions', 'totalRevenue', 'bestSellingProducts'));
    }
}
