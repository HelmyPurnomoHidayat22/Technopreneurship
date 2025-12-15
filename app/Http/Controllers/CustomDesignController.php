<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CustomDesignFile;
use App\Models\OrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomDesignController extends Controller
{
    /**
     * Upload design file (Admin only)
     */
    public function uploadDesign(Request $request, Order $order)
    {
        // Verify order is custom design and approved
        if (!$order->isCustomDesign()) {
            return back()->with('error', 'Pesanan ini bukan Custom Design');
        }

        if (!in_array($order->status, ['approved', 'in_progress', 'revision'])) {
            return back()->with('error', 'Pesanan belum disetujui atau sudah selesai');
        }

        $request->validate([
            'design_file' => 'required|file|mimes:pdf,zip,rar,psd,ai,eps,fig,sketch|max:51200', // 50MB
            'notes' => 'nullable|string|max:500',
        ]);

        // Get next version number
        $version = $order->customDesignFiles()->where('file_type', 'design')->count() + 1;

        // Store file
        $file = $request->file('design_file');
        $filename = 'design_v' . $version . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('custom_orders/' . $order->id . '/designs', $filename, 'private');

        // Save to database
        CustomDesignFile::create([
            'order_id' => $order->id,
            'uploaded_by' => Auth::id(),
            'uploader_role' => 'admin',
            'file_path' => $path,
            'file_type' => 'design',
            'notes' => $request->notes,
            'version' => $version,
        ]);

        // Update order status to in_progress if approved
        if ($order->status === 'approved') {
            $order->update(['status' => 'in_progress']);
        }

        // Send chat notification
        OrderMessage::create([
            'order_id' => $order->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'admin',
            'message' => "🎨 Admin mengunggah desain versi {$version}" . ($request->notes ? " - {$request->notes}" : ""),
            'is_read' => false,
        ]);

        return back()->with('success', 'File desain berhasil di-upload (Versi ' . $version . ')');
    }

    /**
     * Download design file (Admin & User)
     */
    public function downloadDesignFile(Order $order, CustomDesignFile $file)
    {
        // Verify file belongs to order
        if ($file->order_id !== $order->id) {
            abort(404);
        }

        // Admin can download all, user only their own order
        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return Storage::disk('private')->download($file->file_path);
    }

    /**
     * Download design file (User) - Legacy route
     */
    public function downloadDesign(Order $order, CustomDesignFile $file)
    {
        // Verify user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Verify file belongs to order
        if ($file->order_id !== $order->id) {
            abort(404);
        }

        return Storage::disk('private')->download($file->file_path);
    }

    /**
     * Upload revision/feedback (User)
     */
    public function uploadRevision(Request $request, Order $order)
    {
        // Verify user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($order->status, ['in_progress', 'revision'])) {
            return back()->with('error', 'Tidak dapat upload revisi pada status ini');
        }

        $request->validate([
            'revision_file' => 'nullable|file|mimes:pdf,zip,rar,png,jpg,jpeg|max:10240', // 10MB
            'revision_notes' => 'required|string|max:500',
        ]);

        // Get next version number
        $version = $order->customDesignFiles()->where('file_type', 'revision')->count() + 1;

        // Store file if provided
        $path = null;
        if ($request->hasFile('revision_file')) {
            $file = $request->file('revision_file');
            $filename = 'revision_v' . $version . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('custom_orders/' . $order->id . '/revisions', $filename, 'private');
        }

        // Save to database
        CustomDesignFile::create([
            'order_id' => $order->id,
            'uploaded_by' => Auth::id(),
            'uploader_role' => 'user',
            'file_path' => $path,
            'file_type' => 'revision',
            'notes' => $request->revision_notes,
            'version' => $version,
        ]);

        // Update order status to revision
        $order->update(['status' => 'revision']);

        // Send chat notification
        OrderMessage::create([
            'order_id' => $order->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'user',
            'message' => "📝 User mengunggah feedback revisi versi {$version} - {$request->revision_notes}",
            'is_read' => false,
        ]);

        return back()->with('success', 'Revisi berhasil dikirim ke admin');
    }

    /**
     * Get file history for an order
     */
    public function getFileHistory(Order $order)
    {
        $files = $order->customDesignFiles()
            ->with('uploader')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($files);
    }
}
