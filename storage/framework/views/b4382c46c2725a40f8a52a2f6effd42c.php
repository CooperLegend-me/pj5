<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="order-details">
        <div class="order-header">
            <h1>Заказ #<?php echo e($order->id); ?></h1>
            <span class="status-badge status-<?php echo e($order->status); ?>">
                <?php switch($order->status):
                    case ('pending'): ?> Ожидает <?php break; ?>
                    <?php case ('in_progress'): ?> В работе <?php break; ?>
                    <?php case ('completed'): ?> Завершен <?php break; ?>
                <?php endswitch; ?>
            </span>
        </div>

        <div class="order-info">
            <div class="info-section">
                <h3>Информация о клиенте</h3>
                <p><strong>Имя:</strong> <?php echo e($order->user->name); ?></p>
                <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
            </div>

            <div class="info-section">
                <h3>Основная информация</h3>
                <p><strong>Дата создания:</strong> <?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
                <p><strong>Стоимость:</strong> <?php echo e(number_format($order->total_cost, 0, ',', ' ')); ?> ₽</p>
                <p><strong>Тип дома:</strong> 
                    <?php switch($order->house_type):
                        case ('brevna'): ?> Бревенчатый <?php break; ?>
                        <?php case ('brus'): ?> Брусчатый <?php break; ?>
                        <?php case ('kirpich'): ?> Кирпичный <?php break; ?>
                        <?php case ('block'): ?> Блочный <?php break; ?>
                        <?php default: ?> <?php echo e($order->house_type); ?>

                    <?php endswitch; ?>
                </p>
                <p><strong>Тип крыши:</strong> 
                    <?php switch($order->roof_type):
                        case ('flat'): ?>
                            Плоская
                            <?php break; ?>
                        <?php case ('gable'): ?>
                            Двускатная
                            <?php break; ?>
                        <?php case ('hip'): ?>
                            Вальмовая
                            <?php break; ?>
                        <?php case ('shingle'): ?>
                            Металлочерепица
                            <?php break; ?>
                        <?php case ('metal'): ?>
                            Металлическая
                            <?php break; ?>
                        <?php case ('tile'): ?>
                            Черепица
                            <?php break; ?>
                        <?php default: ?>
                            <?php echo e($order->roof_type); ?>

                    <?php endswitch; ?>
                </p>
                <p><strong>Тип фундамента:</strong> 
                    <?php switch($order->foundation_type):
                        case ('strip'): ?> Ленточный <?php break; ?>
                        <?php case ('pile'): ?> Свайный <?php break; ?>
                        <?php case ('slab'): ?> Плитный <?php break; ?>
                        <?php default: ?> <?php echo e($order->foundation_type); ?>

                    <?php endswitch; ?>
                </p>
            </div>

            <div class="info-section">
                <h3>Управление заказом</h3>
                <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="form-group">
                        <label for="status">Статус заказа</label>
                        <select name="status" id="status" class="form-control" style="height: 50px; font-size: 16px; padding: 8px;">
                            <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Ожидает</option>
                            <option value="in_progress" <?php echo e($order->status === 'in_progress' ? 'selected' : ''); ?>>В работе</option>
                            <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>Завершен</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Заметки администратора</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" style="min-height: 100px;"><?php echo e($order->admin_notes); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Обновить статус</button>
                </form>
            </div>
        </div>

        <div class="order-actions">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">Назад к списку</a>
        </div>

        <div class="chat-section">
            <h3>Чат с клиентом</h3>
            <div class="chat-messages" id="messages-<?php echo e($order->id); ?>">
                <?php $__currentLoopData = $order->messages()->with('user')->orderBy('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="message <?php echo e($message->is_admin ? 'message-admin' : 'message-user'); ?>" data-message-id="<?php echo e($message->id); ?>">
                        <div class="message-header">
                            <span class="message-name"><?php echo e($message->user->name); ?></span>
                            <span class="message-time"><?php echo e($message->created_at->format('d.m.Y H:i')); ?></span>
                        </div>
                        <div class="message-content"><?php echo e($message->message); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <form id="chat-form-<?php echo e($order->id); ?>" class="chat-form" onsubmit="event.preventDefault(); sendMessage(<?php echo e($order->id); ?>); return false;">
                <?php echo csrf_field(); ?>
                <div class="chat-input-wrapper">
                    <input type="text" id="message-input-<?php echo e($order->id); ?>" class="chat-input" placeholder="Введите сообщение..." autocomplete="off">
                    <button type="submit" class="btn btn-primary chat-send-btn">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
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

.form-group {
    margin-bottom: 1rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #08373d;
    box-shadow: 0 0 0 2px rgba(8, 55, 61, 0.1);
}

.order-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: flex-start;
    gap: 1rem;
}

.chat-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
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
    margin-right: auto;
    background: #f5f5f5;
}

.message-admin {
    margin-left: auto;
    background: #e3f2fd;
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
    border: none;
}

.btn-primary:hover {
    background: #0a4a52;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/chat.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>