@extends('layouts.app')

@section('content')
<div class="container">
    <div class="order-details">
        <div class="order-header">
            <h1>Заказ #{{ $order->id }}</h1>
            <span class="order-status status-{{ $order->status }}">
                @switch($order->status)
                    @case('pending')
                        Не обработан
                        @break
                    @case('in_progress')
                        В процессе
                        @break
                    @case('completed')
                        Завершен
                        @break
                @endswitch
            </span>
        </div>

        <div class="info-section">
            <h3>Основная информация</h3>
            <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Стоимость:</strong> {{ number_format($order->total_cost, 2) }} руб.</p>
        </div>

        <div class="chat-section">
            <h3>Чат с администратором</h3>
            <div class="chat-messages" id="messages-{{ $order->id }}">
                @foreach($order->messages()->with('user')->orderBy('created_at', 'asc')->get() as $message)
                    <div class="message {{ $message->is_admin ? 'message-admin' : 'message-user' }}" data-message-id="{{ $message->id }}">
                        <div class="message-header">
                            <span class="message-name">{{ $message->user->name }}</span>
                            <span class="message-time">{{ $message->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="message-content">{{ $message->message }}</div>
                    </div>
                @endforeach
            </div>
            <form id="chat-form-{{ $order->id }}" class="chat-form" onsubmit="event.preventDefault(); sendMessage({{ $order->id }}); return false;">
                @csrf
                <div class="chat-input-wrapper">
                    <input type="text" id="message-input-{{ $order->id }}" class="chat-input" placeholder="Введите сообщение..." autocomplete="off">
                    <button type="submit" class="btn btn-primary chat-send-btn">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.order-details {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-in_progress {
    background: #cce5ff;
    color: #004085;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.info-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.info-section h3 {
    margin-bottom: 1rem;
    color: #08373d;
}

.chat-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
}

.chat-section h3 {
    margin-bottom: 1.5rem;
    color: #08373d;
}

.chat-messages {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.message {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: 8px;
    max-width: 80%;
}

.message-user {
    margin-left: auto;
    background: #e3f2fd;
}

.message-admin {
    margin-right: auto;
    background: #f5f5f5;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.message-name {
    font-weight: 500;
    color: #08373d;
}

.message-time {
    color: #6c757d;
    font-size: 0.85rem;
}

.message-content {
    color: #212529;
    line-height: 1.4;
}

.chat-input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

.chat-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s;
}

.chat-input:focus {
    outline: none;
    border-color: #08373d;
    box-shadow: 0 0 0 2px rgba(8, 55, 61, 0.1);
}

.chat-send-btn {
    align-self: flex-end;
    background: #08373d;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 500;
    transition: background-color 0.2s;
    white-space: nowrap;
    min-width: 150px;
}

.chat-send-btn:hover {
    background: #0a4a52;
}

/* Стили для скроллбара */
.chat-messages::-webkit-scrollbar {
    width: 8px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #08373d;
    border-radius: 4px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #0a4a52;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endpush
@endsection 