<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="order-details">
        <div class="order-header">
            <h1>Заказ #<?php echo e($order->id); ?></h1>
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

        <div class="order-info">
            <div class="info-section">
                <h3>Основная информация</h3>
                <p><strong>Дата создания:</strong> <?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
                <p><strong>Стоимость:</strong> <?php echo e(number_format($order->total_cost, 2)); ?> руб.</p>
            </div>

            <div class="info-section">
                <h3>Детали расчета</h3>
                <div class="calculation-details">
                    <p><strong>Тип дома:</strong> 
                        <?php switch($order->house_type):
                            case ('brevna'): ?>
                                Бревенчатый дом
                                <?php break; ?>
                            <?php case ('brus'): ?>
                                Брусчатый дом
                                <?php break; ?>
                            <?php case ('kirpich'): ?>
                                Кирпичный дом
                                <?php break; ?>
                            <?php case ('block'): ?>
                                Блочный дом
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->house_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Тип крыши:</strong> 
                        <?php switch($order->roof_type):
                            case ('gable'): ?>
                                Двускатная
                                <?php break; ?>
                            <?php case ('hip'): ?>
                                Вальмовая
                                <?php break; ?>
                            <?php case ('flat'): ?>
                                Плоская
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->roof_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Тип фундамента:</strong> 
                        <?php switch($order->foundation_type):
                            case ('strip'): ?>
                                Ленточный
                                <?php break; ?>
                            <?php case ('pile'): ?>
                                Свайный
                                <?php break; ?>
                            <?php case ('slab'): ?>
                                Плитный
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->foundation_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Материал отделки:</strong> 
                        <?php switch($order->finishing_material):
                            case ('plaster'): ?>
                                Штукатурка
                                <?php break; ?>
                            <?php case ('siding'): ?>
                                Сайдинг
                                <?php break; ?>
                            <?php case ('brick'): ?>
                                Кирпич
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->finishing_material); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Тип окон:</strong> 
                        <?php switch($order->windows_type):
                            case ('plastic'): ?>
                                Пластиковые
                                <?php break; ?>
                            <?php case ('wooden'): ?>
                                Деревянные
                                <?php break; ?>
                            <?php case ('aluminum'): ?>
                                Алюминиевые
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->windows_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Тип отопления:</strong> 
                        <?php switch($order->heating_type):
                            case ('gas'): ?>
                                Газовое
                                <?php break; ?>
                            <?php case ('electric'): ?>
                                Электрическое
                                <?php break; ?>
                            <?php case ('solid_fuel'): ?>
                                Твердотопливное
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->heating_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Тип канализации:</strong> 
                        <?php switch($order->sewage_type):
                            case ('central'): ?>
                                Центральная
                                <?php break; ?>
                            <?php case ('septic'): ?>
                                Септик
                                <?php break; ?>
                            <?php case ('cesspool'): ?>
                                Выгребная яма
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($order->sewage_type); ?>

                        <?php endswitch; ?>
                    </p>
                    <p><strong>Срок строительства:</strong> <?php echo e($order->construction_time); ?> месяцев</p>
                    <?php if(!empty($order->additional_services)): ?>
                        <p><strong>Дополнительные услуги:</strong></p>
                        <ul>
                            <?php $__currentLoopData = $order->additional_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($service); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($order->admin_notes): ?>
            <div class="info-section">
                <h3>Комментарии администратора</h3>
                <p><?php echo e($order->admin_notes); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <div class="chat-section">
            <h3>Чат с администратором</h3>
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

        <div class="order-actions">
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">Назад к списку</a>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/chat.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/orders/show.blade.php ENDPATH**/ ?>