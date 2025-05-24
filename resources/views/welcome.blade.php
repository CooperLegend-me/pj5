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

<section class="advantages-section">
    <div class="advantages-container">
        <h2 class="section-title">Почему выбирают нас</h2>
        <div class="advantages-grid">
            <div class="advantage-card">
                <div class="advantage-number">01</div>
                <h3 class="advantage-title">Опыт работы</h3>
                <p class="advantage-description">Более 10 лет успешной работы в сфере строительства и ремонта</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-number">02</div>
                <h3 class="advantage-title">Гарантия качества</h3>
                <p class="advantage-description">Предоставляем гарантию на все виды работ и используемые материалы</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-number">03</div>
                <h3 class="advantage-title">Профессиональная команда</h3>
                <p class="advantage-description">Квалифицированные специалисты с многолетним опытом работы</p>
                </div>
            <div class="advantage-card">
                <div class="advantage-number">04</div>
                <h3 class="advantage-title">Современное оборудование</h3>
                <p class="advantage-description">Используем новейшие технологии и оборудование для качественного выполнения работ</p>
                </div>
        </div>
    </div>
</section>

<style>
    .hero-section {
        background: linear-gradient(135deg, #1b1b18 0%, #2a2a26 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        color: #fff;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .hero-subtitle {
        font-size: clamp(1.1rem, 2vw, 1.5rem);
        color: #dbdbd7;
        margin-bottom: 2rem;
        max-width: 600px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards 0.2s;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards 0.4s;
    }

    .cta-button {
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .cta-primary {
        background: #f53003;
        color: white;
    }

    .cta-primary:hover {
        background: #d42a02;
        transform: translateY(-2px);
    }

    .cta-secondary {
        background: transparent;
        color: white;
        border: 2px solid #dbdbd7;
    }

    .cta-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .services-section {
        padding: 6rem 2rem;
        background: #ffffff;
    }

    .services-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 3rem);
        color: #1a365d;
        text-align: center;
        margin-bottom: 4rem;
        font-weight: 700;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .service-card {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }

    .service-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .service-title {
        color: #1a365d;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .service-description {
        color: #4a5568;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .advantages-section {
        padding: 6rem 2rem;
        background: #f8fafc;
    }

    .advantages-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .advantages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .advantage-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .advantage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }

    .advantage-number {
        font-size: 3rem;
        font-weight: 700;
        color: #1a365d;
        opacity: 0.2;
        margin-bottom: 1rem;
    }

    .advantage-title {
        color: #1a365d;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .advantage-description {
        color: #4a5568;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .hero-content {
            text-align: center;
            padding: 1rem;
        }

        .cta-buttons {
            justify-content: center;
        }

        .services-section,
        .advantages-section {
            padding: 4rem 1rem;
        }

        .services-grid,
        .advantages-grid {
            grid-template-columns: 1fr;
        }

        .testimonial {
            padding: 1rem;
        }

        .testimonial-content {
            padding: 1.5rem;
        }

        .testimonial-header {
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
        }

        .testimonial-info {
            text-align: center;
            width: 100%;
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
            text-align: center;
        }
    }
</style>
@endsection
