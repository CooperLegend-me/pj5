<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mari-Art - Строительство домов, ремонт и отделка">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Mari-Art - Строительство домов</title>
    <!-- Сначала подключаем базовые стили -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <!-- Затем дополнительные стили -->
    <link rel="stylesheet" href="/css/styles1.css">
    <link rel="stylesheet" href="/css/styles2.css">
    <link rel="stylesheet" href="/css/imagesc.css">
    <!-- В конце подключаем адаптивные стили, чтобы они имели приоритет -->
    <link rel="stylesheet" href="/css/responsive.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <header class="header-12">
        <div class="container-12">
            <div class="logo-12">
                <a href="<?php echo e(route('home')); ?>" class="logo-12" style="text-decoration: none;">
                    <div class="logo-link">
                        <img src="/images/logo1.svg" alt="Mari-Art Logo" class="logo-image-14">
                    </div>
                    <div class="company-name">Mari-Art</div>
                    <div class="brand-name">Строительство и ремонт</div>
                </a>
            </div>
            
            <!-- Новая структура бургер-меню -->
            <div class="burger-menu" id="burger-menu">
                <div class="burger-line"></div>
                <div class="burger-line"></div>
                <div class="burger-line"></div>
                <div class="burger-line"></div>
            </div>
            
            <nav class="nav-container">
                <ul class="nav-list-12">
                    <li><a href="<?php echo e(route('home')); ?>">Главная</a></li>
                    <li><a href="<?php echo e(route('about')); ?>">О нас</a></li>
                    <li><a href="<?php echo e(route('reviews')); ?>">Портфолио</a></li>
                    <li><a href="<?php echo e(route('faq')); ?>">FAQ</a></li>
                    <li><a href="<?php echo e(route('calculator')); ?>">Калькулятор</a></li>
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('login')); ?>">Войти</a></li>
                        <li><a href="<?php echo e(route('register')); ?>">Регистрация</a></li>
                    <?php else: ?>
                        <?php if(auth()->user()->is_admin): ?>
                            <li><a href="<?php echo e(route('admin.orders.index')); ?>">Заказы</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('orders.index')); ?>">Мои заказы</a></li>
                        <?php endif; ?>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="logout-form">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav-button">Выйти</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="<?php echo e(route('home')); ?>">Главная</a>
                <a href="<?php echo e(route('about')); ?>">О нас</a>
                <a href="<?php echo e(route('reviews')); ?>">Портфолио</a>
                <a href="<?php echo e(route('faq')); ?>">FAQ</a>
                <a href="<?php echo e(route('calculator')); ?>">Калькулятор</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->is_admin): ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>">Заказы</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('orders.index')); ?>">Мои заказы</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="footer-info">
                <p>&copy; 2024 Mari-Art. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Сначала подключаем jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Затем наши скрипты -->
    <script src="/js/burger-menu.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="/js/auth23.js"></script>
    <script src="/js/reviews.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/layouts/app.blade.php ENDPATH**/ ?>