@extends('layouts.app')

@section('title', 'Chat - Order #' . $order->order_code)

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    {{-- Back Button --}}
    <div class="mb-3">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.orders.show', $order) : route('user.orders.show', $order) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Detail Pesanan
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots me-2"></i>Chat - Order #{{ $order->order_code }}
                    </h5>
                    <small>{{ $order->product->title }}</small>
                </div>
                
                <div class="card-body p-0">
                    {{-- Chat Messages --}}
                    <div id="chatMessages" class="p-4" style="height: 500px; overflow-y: auto; background: #f8f9fa;">
                        @forelse($messages as $message)
                            <div class="mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : '' }}" data-message-id="{{ $message->id }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    <div class="p-3 rounded {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-white border' }}">
                                        <div class="small mb-1">
                                            <strong>{{ $message->sender->name }}</strong>
                                            <span class="badge {{ $message->sender_role === 'admin' ? 'bg-danger' : 'bg-info' }} ms-1">
                                                {{ $message->sender_role === 'admin' ? 'Admin' : 'User' }}
                                            </span>
                                        </div>
                                        <div>{{ $message->message }}</div>
                                        <div class="small mt-2 opacity-75 message-time" data-time="{{ $message->created_at->timestamp }}">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-chat-dots fs-1"></i>
                                <p class="mt-2">Belum ada pesan. Mulai percakapan!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Message Input --}}
                    <div class="p-3 border-top bg-white">
                        <form id="chatForm">
                            @csrf
                            <div class="input-group">
                                <input type="text" 
                                       id="messageInput" 
                                       class="form-control" 
                                       placeholder="Ketik pesan..." 
                                       maxlength="1000"
                                       required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim
                                </button>
                            </div>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const chatMessages = document.getElementById('chatMessages');
const chatForm = document.getElementById('chatForm');
const messageInput = document.getElementById('messageInput');
const orderId = {{ $order->id }};

// Format timestamp to relative time
function timeAgo(timestamp) {
    const now = Math.floor(Date.now() / 1000);
    const secondsAgo = now - timestamp;
    
    if (secondsAgo < 60) {
        return 'Baru saja';
    } else if (secondsAgo < 3600) {
        const minutes = Math.floor(secondsAgo / 60);
        return `${minutes} menit yang lalu`;
    } else if (secondsAgo < 86400) {
        const hours = Math.floor(secondsAgo / 3600);
        return `${hours} jam yang lalu`;
    } else if (secondsAgo < 604800) {
        const days = Math.floor(secondsAgo / 86400);
        return `${days} hari yang lalu`;
    } else {
        // Show absolute date for old messages
        const date = new Date(timestamp * 1000);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }
}

// Update all timestamps
function updateTimestamps() {
    document.querySelectorAll('.message-time').forEach(el => {
        const timestamp = parseInt(el.getAttribute('data-time'));
        el.textContent = timeAgo(timestamp);
    });
}

// Auto-scroll to bottom
function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Send message
chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const message = messageInput.value.trim();
    if (!message) return;
    
    try {
        const response = await fetch(`/orders/${orderId}/chat/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message })
        });
        
        const data = await response.json();
        
        if (data.success) {
            messageInput.value = '';
            appendMessage(data.message);
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Gagal mengirim pesan');
    }
});

// Append message to chat
function appendMessage(message) {
    // Remove empty state if exists
    const emptyState = chatMessages.querySelector('.text-center.text-muted');
    if (emptyState) {
        emptyState.remove();
    }
    
    const isOwn = message.sender_id === {{ auth()->id() }};
    const timestamp = message.created_at ? new Date(message.created_at).getTime() / 1000 : Math.floor(Date.now() / 1000);
    
    const messageHtml = `
        <div class="mb-3 ${isOwn ? 'text-end' : ''}" data-message-id="${message.id}">
            <div class="d-inline-block" style="max-width: 70%;">
                <div class="p-3 rounded ${isOwn ? 'bg-primary text-white' : 'bg-white border'}">
                    <div class="small mb-1">
                        <strong>${message.sender.name}</strong>
                        <span class="badge ${message.sender_role === 'admin' ? 'bg-danger' : 'bg-info'} ms-1">
                            ${message.sender_role === 'admin' ? 'Admin' : 'User'}
                        </span>
                    </div>
                    <div>${message.message}</div>
                    <div class="small mt-2 opacity-75 message-time" data-time="${timestamp}">
                        ${timeAgo(timestamp)}
                    </div>
                </div>
            </div>
        </div>
    `;
    chatMessages.insertAdjacentHTML('beforeend', messageHtml);
}

// Polling for new messages (every 5 seconds)
setInterval(async () => {
    try {
        const response = await fetch(`/orders/${orderId}/chat/messages`);
        const messages = await response.json();
        
        messages.forEach(message => {
            // Check if message already exists
            const exists = chatMessages.querySelector(`[data-message-id="${message.id}"]`);
            if (!exists) {
                appendMessage(message);
            }
        });
        
        scrollToBottom();
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
}, 5000);

// Update timestamps every minute
setInterval(updateTimestamps, 60000);

// Initial setup
updateTimestamps();
scrollToBottom();
</script>
@endpush
@endsection
