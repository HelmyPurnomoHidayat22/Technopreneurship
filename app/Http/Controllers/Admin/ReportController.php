<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sales report
     */
    public function index(Request $request)
    {
        // Include both paid and completed orders in statistics
        $totalTransactions = Order::whereIn('status', ['paid', 'completed'])->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'completed'])->sum('amount');
        
        
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
            ->whereIn('orders.status', ['paid', 'completed'])
            ->groupBy('products.id', 'products.title', 'products.price', 'products.preview_image', 'products.category_id')
            ->orderBy('total_orders', 'desc')
            ->get();


        // Sales by status
        $salesByStatus = Order::select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact('totalTransactions', 'totalRevenue', 'bestSellingProducts', 'salesByStatus'));
    }
}
