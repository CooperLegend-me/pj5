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

        <div class="order-info">
            <div class="info-section">
                <h3>Основная информация</h3>
                <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Стоимость:</strong> {{ number_format($order->total_cost, 2) }} руб.</p>
            </div>

            <div class="info-section">
                <h3>Детали расчета</h3>
                <div class="calculation-details">
                    <p><strong>Тип дома:</strong> 
                        @switch($order->house_type)
                            @case('brevna')
                                Бревенчатый дом
                                @break
                            @case('brus')
                                Брусчатый дом
                                @break
                            @case('kirpich')
                                Кирпичный дом
                                @break
                            @case('block')
                                Блочный дом
                                @break
                            @default
                                {{ $order->house_type }}
                        @endswitch
                    </p>
                    <p><strong>Тип крыши:</strong> 
                        @switch($order->roof_type)
                            @case('gable')
                                Двускатная
                                @break
                            @case('hip')
                                Вальмовая
                                @break
                            @case('flat')
                                Плоская
                                @break
                            @default
                                {{ $order->roof_type }}
                        @endswitch
                    </p>
                    <p><strong>Тип фундамента:</strong> 
                        @switch($order->foundation_type)
                            @case('strip')
                                Ленточный
                                @break
                            @case('pile')
                                Свайный
                                @break
                            @case('slab')
                                Плитный
                                @break
                            @default
                                {{ $order->foundation_type }}
                        @endswitch
                    </p>
                    <p><strong>Материал отделки:</strong> 
                        @switch($order->finishing_material)
                            @case('plaster')
                                Штукатурка
                                @break
                            @case('siding')
                                Сайдинг
                                @break
                            @case('brick')
                                Кирпич
                                @break
                            @default
                                {{ $order->finishing_material }}
                        @endswitch
                    </p>
                    <p><strong>Тип окон:</strong> 
                        @switch($order->windows_type)
                            @case('plastic')
                                Пластиковые
                                @break
                            @case('wooden')
                                Деревянные
                                @break
                            @case('aluminum')
                                Алюминиевые
                                @break
                            @default
                                {{ $order->windows_type }}
                        @endswitch
                    </p>
                    <p><strong>Тип отопления:</strong> 
                        @switch($order->heating_type)
                            @case('gas')
                                Газовое
                                @break
                            @case('electric')
                                Электрическое
                                @break
                            @case('solid_fuel')
                                Твердотопливное
                                @break
                            @default
                                {{ $order->heating_type }}
                        @endswitch
                    </p>
                    <p><strong>Тип канализации:</strong> 
                        @switch($order->sewage_type)
                            @case('central')
                                Центральная
                                @break
                            @case('septic')
                                Септик
                                @break
                            @case('cesspool')
                                Выгребная яма
                                @break
                            @default
                                {{ $order->sewage_type }}
                        @endswitch
                    </p>
                    <p><strong>Срок строительства:</strong> {{ $order->construction_time }} месяцев</p>
                    @if(!empty($order->additional_services))
                        <p><strong>Дополнительные услуги:</strong></p>
                        <ul>
                            @foreach($order->additional_services as $service)
                                <li>{{ $service }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            @if($order->admin_notes)
            <div class="info-section">
                <h3>Комментарии администратора</h3>
                <p>{{ $order->admin_notes }}</p>
            </div>
            @endif
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

        <div class="order-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад к списку</a>
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

.order-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

.status-pending {
    background: #ffd700;
    color: #000;
}

.status-in_progress {
    background: #1e90ff;
    color: #fff;
}

.status-completed {
    background: #32cd32;
    color: #fff;
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

.calculation-details p {
    margin: 0.5rem 0;
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
    margin-bottom: 1.5rem;
    padding: 1.5rem;
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
    min-height: 80px;
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s;
    resize: vertical;
}

.chat-input:focus {
    outline: none;
    border-color: #08373d;
    box-shadow: 0 0 0 2px rgba(8, 55, 61, 0.1);
}

.chat-send-btn {
    width: 100%;
    background: #08373d;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 1rem;
    font-size: 1rem;
    font-weight: 500;
    transition: background-color 0.2s;
    cursor: pointer;
}

.chat-send-btn:hover {
    background: #0a4a52;
}

.order-actions {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: background-color 0.2s;
}

.btn-primary {
    background: #08373d;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endpush
@endsection 