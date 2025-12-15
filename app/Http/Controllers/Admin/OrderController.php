<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with(['user', 'product'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display specific order details
     */
    public function show(Order $order)
    {
        $order->load(['user', 'product.category']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Verify payment and approve order
     */
    public function verifyPayment(Order $order)
    {
        if ($order->status !== 'waiting_verification') {
            return back()->with('error', 'Order status is not valid for verification.');
        }

        $order->status = 'paid';
        $order->generateDownloadToken();
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Payment verified and download link activated.');
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, Order $order)
    {
        if ($order->status !== 'waiting_verification') {
            return back()->with('error', 'Status pesanan tidak valid untuk penolakan.');
        }

        // Validate rejection note
        $validated = $request->validate([
            'rejection_note' => 'required|string|min:10|max:500',
        ], [
            'rejection_note.required' => 'Catatan penolakan wajib diisi',
            'rejection_note.min' => 'Catatan minimal 10 karakter',
            'rejection_note.max' => 'Catatan maksimal 500 karakter',
        ]);

        $order->status = 'rejected';
        $order->rejection_note = $validated['rejection_note'];
        $order->rejected_at = now();
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil ditolak dan catatan dikirim ke user.');
    }

    /**
     * Approve custom design order
     */
    public function approve(Order $order)
    {
        if (!$order->isCustomDesign()) {
            return back()->with('error', 'Hanya pesanan Custom Design yang bisa disetujui');
        }

        if ($order->status !== 'paid') {
            return back()->with('error', 'Pesanan harus sudah dibayar terlebih dahulu');
        }

        $order->update(['status' => 'approved']);

        return back()->with('success', 'Pesanan Custom Design disetujui. Chat sekarang aktif.');
    }

    /**
     * Mark order as in progress
     */
    public function markInProgress(Order $order)
    {
        if (!in_array($order->status, ['approved', 'revision'])) {
            return back()->with('error', 'Status tidak valid');
        }

        $order->update(['status' => 'in_progress']);

        return back()->with('success', 'Status diubah menjadi Proses Desain');
    }

    /**
     * Mark order as completed
     */
    public function markCompleted(Order $order)
    {
        if (!in_array($order->status, ['in_progress', 'revision'])) {
            return back()->with('error', 'Status tidak valid');
        }

        // Check if design file has been uploaded
        if ($order->isCustomDesign() && $order->customDesignFiles()->where('file_type', 'design')->count() === 0) {
            return back()->with('error', 'Belum ada file desain yang di-upload');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Pesanan ditandai sebagai Selesai');
    }
}
