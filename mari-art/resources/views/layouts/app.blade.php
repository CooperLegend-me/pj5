<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mari-Art - Строительство домов, ремонт и отделка">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @stack('styles')
</head>
<body>
    <header class="header-12">
        <div class="container-12">
            <div class="logo-12">
                <a href="{{ route('home') }}" class="logo-12" style="text-decoration: none;">
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
                    <li><a href="{{ route('home') }}">Главная</a></li>
                    <li><a href="{{ route('about') }}">О нас</a></li>
                    <li><a href="{{ route('reviews') }}">Портфолио</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                    <li><a href="{{ route('calculator') }}">Калькулятор</a></li>
                    @guest
                        <li><a href="{{ route('login') }}">Войти</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                    @else
                        @if(auth()->user()->is_admin)
                            <li><a href="{{ route('admin.orders.index') }}">Заказы</a></li>
                        @else
                            <li><a href="{{ route('orders.index') }}">Мои заказы</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                @csrf
                                <button type="submit" class="nav-button">Выйти</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('about') }}">О нас</a>
                <a href="{{ route('reviews') }}">Портфолио</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('calculator') }}">Калькулятор</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.orders.index') }}">Заказы</a>
                    @else
                        <a href="{{ route('orders.index') }}">Мои заказы</a>
                    @endif
                @endauth
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
    @stack('scripts')
</body>
</html> 