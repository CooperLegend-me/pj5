@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<section class="hero">
    <div class="hero-content">
        <h2>Качественное строительство и ремонт</h2>
        <p>Мы предлагаем широкий спектр услуг по строительству и ремонту домов, бань и дач.</p>
        <a href="{{ route('calculator') }}" class="btn">Рассчитать стоимость дома</a>
    </div>
</section>

<section id="services" class="services">
    <div class="container">
        <h2 class="services-title">Наши Услуги</h2>
        <div class="slider">
            <div class="service">
                <div class="service-wrapper">
                    <div class="service-content">
                        <h3>Строительство домов</h3>
                        <p>Мы строим дома на основе индивидуальных проектов, учитывая все пожелания клиентов. Наша команда специалистов гарантирует качественное выполнение работ с использованием современных технологий и материалов.</p>
                        <ul class="service-features">
                            <li>Индивидуальные проекты</li>
                            <li>Современные технологии</li>
                            <li>Контроль качества</li>
                            <li>Гарантия на работы</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="service">
                <div class="service-wrapper">
                    <div class="service-content">
                        <h3>Ремонт квартир</h3>
                        <p>Качественный ремонт любых помещений, от косметического до капитального. Мы поможем создать уютное и стильное пространство для жизни. Наши дизайнеры разработают уникальный проект.</p>
                        <ul class="service-features">
                            <li>Дизайн-проект</li>
                            <li>Капитальный ремонт</li>
                            <li>Косметический ремонт</li>
                            <li>Отделочные работы</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="service">
                <div class="service-wrapper">
                    <div class="service-content">
                        <h3>Строительство бань</h3>
                        <p>Построим баню с учетом всех ваших пожеланий. Мы используем экологически чистые материалы и современные технологии строительства. Каждая баня проектируется индивидуально.</p>
                        <ul class="service-features">
                            <li>Экологичные материалы</li>
                            <li>Индивидуальный проект</li>
                            <li>Современные технологии</li>
                            <li>Комплексное оснащение</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="service">
                <div class="service-wrapper">
                    <div class="service-content">
                        <h3>Дачное строительство</h3>
                        <p>Строим дачи под ключ, включая все необходимые коммуникации. Обеспечим комфорт и уют для вашего отдыха. Мы учитываем все особенности дачного строительства.</p>
                        <ul class="service-features">
                            <li>Коммуникации</li>
                            <li>Благоустройство участка</li>
                            <li>Отделка под ключ</li>
                            <li>Гарантия качества</li>
                        </ul>
                    </div>
                </div>
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
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Алексей Смирнов</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Строительство бани было выполнено на высшем уровне!"</p>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Ольга Кузнецова</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Отличное качество и профессиональный подход!"</p>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Сергей Иванов</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Спасибо за качественный ремонт квартиры! Все работы выполнены в срок и на высшем уровне."</p>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <div class="testimonial-header">
                        <img src="/images/user.png" alt="user" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Елена Соколова</h4>
                            <div class="testimonial-rating">★★★★★</div>
                        </div>
                    </div>
                    <p class="testimonial-text">"Построили отличную дачу! Учитывали все наши пожелания и предложили интересные решения."</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<style>
    .services {
        padding: 4rem 0;
        background: #f8fafc;
    }

    .services-title {
        font-size: clamp(2rem, 4vw, 3rem);
        color: #08373d;
        text-align: center;
        margin-bottom: 3rem;
        font-weight: 700;
    }

    .slider {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .service {
        padding: 1rem;
    }

    .service-wrapper {
        display: flex;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: auto;
        min-height: 400px;
    }

    .service-content {
        flex: 1;
        padding: 2.5rem;
    }

    .service-content h3 {
        color: #08373d;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .service-content p {
        color: #4a5568;
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .service-features {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .service-features li {
        color: #08373d;
        font-size: 1.2rem;
        padding-left: 1.5rem;
        position: relative;
    }

    .service-features li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #f53003;
    }

    .testimonials {
        padding: 6rem 0;
        background: #ffffff;
        position: relative;
    }

    .testimonials .section-title {
        color: #2f4f4f;
    }

    .testimonial-slider {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .testimonial {
        padding: 1.5rem;
    }

    .testimonial-content {
        background: #ffffff;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        border: 2px solid #08373d;
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
        color: #08373d;
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
        color: #2d3748;
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

    /* Стили для точек слайдера */
    .testimonials .slick-dots li button:before {
        color: rgba(8, 55, 61, 0.5);
    }

    .testimonials .slick-dots li.slick-active button:before {
        color: #08373d;
    }

    @media (max-width: 768px) {
        .services,
        .testimonials {
            padding: 4rem 1rem;
        }

        .service-wrapper {
            min-height: 350px;
        }

        .service-content {
            padding: 2rem;
        }

        .service-content h3 {
            font-size: 1.8rem;
        }

        .service-content p {
            font-size: 1.1rem;
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
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnHover: true,
            pauseOnFocus: true,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        dots: false
                    }
                }
            ]
        });

        $('.testimonial-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            pauseOnHover: true,
            pauseOnFocus: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });
    });
</script>
@endpush
@endsection 