<?php $__env->startSection('content'); ?>
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
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td><?php echo e($order->user->name); ?></td>
                            <td><?php echo e($order->user->email); ?></td>
                            <td>
                                <?php switch($order->house_type):
                                    case ('brevna'): ?> Бревенчатый <?php break; ?>
                                    <?php case ('brus'): ?> Брусчатый <?php break; ?>
                                    <?php case ('kirpich'): ?> Кирпичный <?php break; ?>
                                    <?php case ('block'): ?> Блочный <?php break; ?>
                                    <?php default: ?> <?php echo e($order->house_type); ?>

                                <?php endswitch; ?>
                            </td>
                            <td>
                                <?php switch($order->roof_type):
                                    case ('flat'): ?> Плоская <?php break; ?>
                                    <?php case ('shingle'): ?> Металлочерепица <?php break; ?>
                                    <?php case ('metal'): ?> Металлическая <?php break; ?>
                                    <?php case ('tile'): ?> Черепица <?php break; ?>
                                    <?php default: ?> <?php echo e($order->roof_type); ?>

                                <?php endswitch; ?>
                            </td>
                            <td>
                                <?php switch($order->foundation_type):
                                    case ('strip'): ?> Ленточный <?php break; ?>
                                    <?php case ('pile'): ?> Свайный <?php break; ?>
                                    <?php case ('slab'): ?> Плитный <?php break; ?>
                                    <?php default: ?> <?php echo e($order->foundation_type); ?>

                                <?php endswitch; ?>
                            </td>
                            <td><?php echo e(number_format($order->total_cost, 0, ',', ' ')); ?> ₽</td>
                            <td>
                                <span class="status-badge status-<?php echo e($order->status); ?>">
                                    <?php switch($order->status):
                                        case ('pending'): ?> Ожидает <?php break; ?>
                                        <?php case ('in_progress'): ?> В работе <?php break; ?>
                                        <?php case ('completed'): ?> Завершен <?php break; ?>
                                    <?php endswitch; ?>
                                </span>
                            </td>
                            <td><?php echo e($order->created_at->format('d.m.Y H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-primary">Просмотр</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
const ctx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($stats['labels']); ?>,
        datasets: [{
            label: 'Количество заказов',
            data: <?php echo json_encode($stats['data']); ?>,
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>