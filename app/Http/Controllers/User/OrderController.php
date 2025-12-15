<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display specific order
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('product.category');
        return view('user.orders.show', compact('order'));
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Cannot upload payment proof for this order.');
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Delete old payment proof if exists
            if ($order->payment_proof_path) {
                Storage::disk('private')->delete($order->payment_proof_path);
            }

            $paymentProof = $request->file('payment_proof');
            $paymentProofPath = $paymentProof->store('payments', 'private');
            $order->payment_proof_path = $paymentProofPath;
            $order->status = 'waiting_verification';
            $order->save();
        }

        return redirect()->route('user.orders.show', $order)
            ->with('success', 'Payment proof uploaded successfully. Waiting for admin verification.');
    }
}
