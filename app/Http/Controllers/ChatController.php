<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat interface
     */
    public function index(Order $order)
    {
        // Check if user has access to this order
        if (Auth::user()->role === 'user' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if chat is active
        if (!$order->isChatActive()) {
            return back()->with('error', 'Chat belum aktif untuk pesanan ini');
        }

        $messages = $order->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        // Mark messages as read
        $order->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.index', compact('order', 'messages'));
    }

    /**
     * Send message
     */
    public function sendMessage(Request $request, Order $order)
    {
        // Check if user has access
        if (Auth::user()->role === 'user' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if chat is active
        if (!$order->isChatActive()) {
            return response()->json(['error' => 'Chat tidak aktif'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = OrderMessage::create([
            'order_id' => $order->id,
            'sender_id' => Auth::id(),
            'sender_role' => Auth::user()->role,
            'message' => $request->message,
            'is_read' => false,
        ]);

        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Get messages (AJAX)
     */
    public function getMessages(Order $order)
    {
        // Check if user has access
        if (Auth::user()->role === 'user' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $messages = $order->messages()
            ->with('sender')
            ->where('created_at', '>', now()->subMinutes(5))
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark new messages as read
        $order->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
