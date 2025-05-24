@extends('layouts.app')

@section('content')
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Строительство и ремонт с профессионалами</h1>
        <p class="hero-subtitle">Мы создаем качественные и долговечные решения для вашего комфорта и безопасности</p>
        
        <div class="cta-buttons">
            <a href="#contact" class="cta-button cta-primary">Связаться с нами</a>
            <a href="#services" class="cta-button cta-secondary">Наши услуги</a>
        </div>
    </div>
</section>

<section class="services-section">
    <div class="services-container">
        <h2 class="section-title">Наши услуги</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🏠</div>
                <h3 class="service-title">Строительство домов</h3>
                <p class="service-description">Проектирование и строительство частных домов под ключ с использованием современных технологий и материалов</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔨</div>
                <h3 class="service-title">Ремонт квартир</h3>
                <p class="service-description">Капитальный и косметический ремонт квартир любой сложности с гарантией качества</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🎨</div>
                <h3 class="service-title">Отделочные работы</h3>
                <p class="service-description">Профессиональная отделка помещений с использованием качественных материалов</p>
            </div>
            <div class="service-card">
                <div class="service-icon">💡</div>
                <h3 class="service-title">Электромонтажные работы</h3>
                <p class="service-description">Монтаж и замена электропроводки, установка осветительных приборов и розеток</p>
            </div>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <h2 class="section-title">Отзывы клиентов</h2>
        <div class="testimonial-slider">
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Иван Петров</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Отличная работа! Мы очень довольны качеством строительства нашего дома!"</p>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Мария Сидорова</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Ремонт прошел быстро и качественно. Рекомендую!"</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<style>
    .testimonials {
        padding: 6rem 0;
        background: #ffffff;
        position: relative;
    }

    .testimonials .section-title {
        color: #08373d;
    }

    .testimonial-content {
        background: #08373d;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .testimonial-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .testimonial-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f53003;
        margin-right: 1.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .testimonial-info {
        flex: 1;
    }

    .testimonial-name {
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }

    .testimonial-rating {
        color: #f53003;
        font-size: 1.2rem;
        letter-spacing: 2px;
    }

    .testimonial-text {
        color: #ffffff;
        font-size: 1.1rem;
        line-height: 1.7;
        font-style: italic;
        margin: 0;
        position: relative;
        padding-left: 1.5rem;
    }

    .testimonial-text:before {
        content: '"';
        position: absolute;
        left: 0;
        top: -0.5rem;
        font-size: 2rem;
        color: #f53003;
        opacity: 0.3;
    }

    .testimonials .slick-dots li button:before {
        color: rgba(8, 55, 61, 0.5);
    }

    .testimonials .slick-dots li.slick-active button:before {
        color: #08373d;
    }

    @media (max-width: 768px) {
        .testimonial {
            padding: 1rem;
        }

        .testimonial-content {
            padding: 1.5rem;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            margin-right: 1rem;
        }

        .testimonial-name {
            font-size: 1.1rem;
        }

        .testimonial-rating {
            font-size: 1rem;
        }

        .testimonial-text {
            font-size: 1rem;
            padding-left: 1rem;
        }
    }
</style>
@endpush 