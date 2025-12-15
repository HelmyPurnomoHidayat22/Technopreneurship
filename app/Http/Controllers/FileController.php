<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    /**
     * Serve preview image
     */
    public function previewImage($path)
    {
        // Find product by preview image filename
        $product = \App\Models\Product::where('preview_image', 'like', '%' . $path)->first();
        
        if (!$product || !$product->preview_image) {
            abort(404);
        }

        $filePath = $product->preview_image;
        
        if (!Storage::disk('private')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('private')->response($filePath);
    }

    /**
     * Serve payment proof (admin only or order owner)
     */
    public function paymentProof($orderId, $path)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        
        // Check if user is admin or owns the order
        if (!auth()->check() || (!auth()->user()->isAdmin() && $order->user_id !== auth()->id())) {
            abort(403);
        }

        if (!$order->payment_proof_path) {
            abort(404);
        }

        $filePath = $order->payment_proof_path;
        
        if (!Storage::disk('private')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('private')->response($filePath);
    }
}
