<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function create(Product $product)
    {
        return view('user.checkout.create', compact('product'));
    }

    /**
     * Process checkout
     */
    public function store(Request $request, Product $product)
    {
        // Basic validation
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // Additional validation for Custom Design products
        if ($product->category && $product->category->name === 'Custom Design') {
            $customValidated = $request->validate([
                'custom_category' => 'required|string',
                'custom_notes' => 'nullable|string|max:1000',
                'custom_deadline' => 'nullable|date|after:today',
                'custom_reference_link' => 'nullable|url|max:500',
            ], [
                'custom_category.required' => 'Kategori custom design wajib dipilih',
                'custom_deadline.after' => 'Deadline harus lebih dari hari ini',
                'custom_reference_link.url' => 'Link referensi harus berupa URL yang valid',
            ]);
            
            $validated = array_merge($validated, $customValidated);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'amount' => $product->price,
            'status' => 'pending',
            'order_code' => Order::generateOrderCode(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'custom_category' => $validated['custom_category'] ?? null,
            'custom_notes' => $validated['custom_notes'] ?? null,
        ]);

        return redirect()->route('user.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
    }
}
