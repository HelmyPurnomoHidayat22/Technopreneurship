<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Download product file
     */
    public function download(Order $order, $token)
    {
        // Verify user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Verify order is paid
        if ($order->status !== 'paid') {
            abort(403, 'Order is not paid');
        }

        // Verify download token
        if ($order->download_token !== $token || !$order->isDownloadTokenValid()) {
            abort(403, 'Invalid or expired download token');
        }

        // Verify product file exists
        if (!$order->product->file_path || !Storage::disk('private')->exists($order->product->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('private')->download($order->product->file_path);
    }
}
