@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <div class="admin-header">
        <h1>Панель администратора</h1>
    </div>

    <div class="admin-content">
        <div class="admin-sidebar">
            <nav>
                <a href="{{ route('admin.orders.index') }}" class="nav-item">
                    <i class="fas fa-list"></i>
                    Заказы
                </a>
                <a href="{{ route('admin.stats') }}" class="nav-item active">
                    <i class="fas fa-chart-bar"></i>
                    Статистика
                </a>
            </nav>
        </div>

        <div class="admin-main">
            <order-stats></order-stats>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-dashboard {
    padding: 2rem;
}

.admin-header {
    margin-bottom: 2rem;
}

.admin-content {
    display: flex;
    gap: 2rem;
}

.admin-sidebar {
    width: 250px;
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}

.nav-item:hover {
    background: #f8f9fa;
}

.nav-item.active {
    background: #007bff;
    color: white;
}

.admin-main {
    flex: 1;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush 