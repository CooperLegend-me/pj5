@extends('layouts.app')

@section('content')
<div class="admin-orders-container">
    <h1 class="admin-title">Управление заказами</h1>

    <!-- График статистики -->
    <div class="stats-section">
        <h3 class="section-title">Статистика заказов</h3>
        <div class="chart-container">
            <canvas id="ordersChart" height="100"></canvas>
        </div>
    </div>

    <!-- Таблица заказов -->
    <div class="orders-list">
        <h3 class="section-title">Все заказы</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Клиент</th>
                        <th>Email</th>
                        <th>Тип дома</th>
                        <th>Тип крыши</th>
                        <th>Тип фундамента</th>
                        <th>Стоимость</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>
                                @switch($order->house_type)
                                    @case('brevna') Бревенчатый @break
                                    @case('brus') Брусчатый @break
                                    @case('kirpich') Кирпичный @break
                                    @case('block') Блочный @break
                                    @default {{ $order->house_type }}
                                @endswitch
                            </td>
                            <td>
                                @switch($order->roof_type)
                                    @case('flat') Плоская @break
                                    @case('shingle') Металлочерепица @break
                                    @case('metal') Металлическая @break
                                    @case('tile') Черепица @break
                                    @default {{ $order->roof_type }}
                                @endswitch
                            </td>
                            <td>
                                @switch($order->foundation_type)
                                    @case('strip') Ленточный @break
                                    @case('pile') Свайный @break
                                    @case('slab') Плитный @break
                                    @default {{ $order->foundation_type }}
                                @endswitch
                            </td>
                            <td>{{ number_format($order->total_cost, 0, ',', ' ') }} ₽</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending') Ожидает @break
                                        @case('in_progress') В работе @break
                                        @case('completed') Завершен @break
                                    @endswitch
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Просмотр</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.admin-orders-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.admin-title {
    color: #08373d;
    margin-bottom: 2rem;
    font-size: 2rem;
    font-weight: 600;
}

.section-title {
    color: #08373d;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    font-weight: 500;
}

.stats-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 100%;
}

.chart-container {
    height: 300px;
    margin-top: 1rem;
}

.orders-list {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 100%;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table th {
    background: #f8f9fa;
    color: #08373d;
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
    display: inline-block;
    min-width: 100px;
    text-align: center;
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

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 1200px) {
    .admin-orders-container {
    padding: 1rem;
}

    .table th, .table td {
    padding: 0.75rem;
    }
}

@media (max-width: 768px) {
    .admin-title {
        font-size: 1.5rem;
}

    .section-title {
        font-size: 1.25rem;
}

    .status-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
}
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
const ctx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($stats['labels']) !!},
        datasets: [{
            label: 'Количество заказов',
            data: {!! json_encode($stats['data']) !!},
            backgroundColor: '#08373d',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
    });
});
</script>
@endpush

@endsection 