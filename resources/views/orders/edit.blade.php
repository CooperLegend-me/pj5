@extends('layouts.app')

@section('content')
<div class="container">
    <div class="edit-order">
        <h1>Изменение статуса заказа #{{ $order->id }}</h1>

        <form action="{{ route('orders.update', $order) }}" method="POST" class="status-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Статус заказа</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="not_processed" {{ $order->status === 'not_processed' ? 'selected' : '' }}>Не обработан</option>
                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>В процессе</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Выполнен</option>
                </select>
                @error('status')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.edit-order {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 2rem;
}

.edit-order h1 {
    margin-bottom: 2rem;
    color: #333;
    font-size: 1.8rem;
}

.status-form {
    max-width: 500px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background: #5a6268;
}
</style>
@endsection 