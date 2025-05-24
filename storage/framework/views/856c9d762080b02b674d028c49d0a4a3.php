<?php $__env->startSection('content'); ?>
<div class="container orders-page">
    <h1>Мои заказы</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="orders-list">
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="order-card">
                <div class="order-header">
                    <h3>Заказ #<?php echo e($order->id); ?></h3>
                    <span class="order-status status-<?php echo e($order->status); ?>">
                        <?php switch($order->status):
                            case ('pending'): ?>
                                Не обработан
                                <?php break; ?>
                            <?php case ('in_progress'): ?>
                                В процессе
                                <?php break; ?>
                            <?php case ('completed'): ?>
                                Завершен
                                <?php break; ?>
                        <?php endswitch; ?>
                    </span>
                </div>
                <div class="order-details">
                    <p><strong>Дата создания:</strong> <?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
                    <p><strong>Стоимость:</strong> <?php echo e(number_format($order->total_cost, 2)); ?> руб.</p>
                </div>
                <div class="order-actions">
                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary">Подробнее</a>
                </div>
                
                <!-- Чат для заказа -->
                <div class="order-chat" id="chat-<?php echo e($order->id); ?>">
                    <div class="chat-messages" id="messages-<?php echo e($order->id); ?>">
                        <?php $__currentLoopData = $order->messages()->with('user')->orderBy('created_at', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="no-orders">
                <p>У вас пока нет заказов</p>
                <a href="<?php echo e(route('calculator')); ?>" class="btn btn-primary">Создать заказ</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.orders-page {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
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

.order-details {
    margin-bottom: 1rem;
}

.order-actions {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 1rem;
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

.no-orders {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 8px;
}

/* Стили для чата */
.order-chat {
    margin-top: 1rem;
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/chat.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/orders/index.blade.php ENDPATH**/ ?>