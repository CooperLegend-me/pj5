@extends('layouts.app')

@section('content')
<div class="container orders-page">
    <h1>Мои заказы</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="orders-list">
        @forelse($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <h3>Заказ #{{ $order->id }}</h3>
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
                <div class="order-details">
                    <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Стоимость:</strong> {{ number_format($order->total_cost, 2) }} руб.</p>
                </div>
                <div class="order-actions">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">Подробнее</a>
                </div>
                
                <!-- Чат для заказа -->
                <div class="order-chat" id="chat-{{ $order->id }}">
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
        @empty
            <div class="no-orders">
                <p>У вас пока нет заказов</p>
                <a href="{{ route('calculator') }}" class="btn btn-primary">Создать заказ</a>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
// ... существующие стили ...
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endpush
@endsection 