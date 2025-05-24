<?php $__env->startSection('content'); ?>
<section class="reviews-section">
    <div class="reviews-container">
        <div class="reviews-grid">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="review-card">
                <div class="review-header">
                    <div class="review-author"><?php echo e($review->author); ?></div>
                    <div class="review-date"><?php echo e($review->created_at->format('d.m.Y')); ?></div>
                </div>
                <div class="review-content">
                    <?php echo e($review->content); ?>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="projects-section">
    <div class="projects-container">
        <h2 class="projects-title">Наши проекты</h2>
        
        <div class="projects-tabs">
            <button class="tab-button active" data-tab="brevna">Бревенчатый дом</button>
            <button class="tab-button" data-tab="brus">Брусчатый дом</button>
            <button class="tab-button" data-tab="kirpich">Кирпичный дом</button>
        </div>

        <div class="projects-content">
            <!-- Бревенчатый дом -->
            <div class="tab-content active" id="brevna">
                <div class="projects-grid">
                    <div class="project-card" onclick="openModal('/images/portfolio/brevna/1.jpg')">
                        <img src="/images/portfolio/brevna/1.jpg" alt="Бревенчатый дом 1">
                        <div class="project-info">
                            <h3>Бревенчатый дом 1</h3>
                            <p>Проект бревенчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brevna/2.jpg')">
                        <img src="/images/portfolio/brevna/2.jpg" alt="Бревенчатый дом 2">
                        <div class="project-info">
                            <h3>Бревенчатый дом 2</h3>
                            <p>Проект бревенчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brevna/3.jpg')">
                        <img src="/images/portfolio/brevna/3.jpg" alt="Бревенчатый дом 3">
                        <div class="project-info">
                            <h3>Бревенчатый дом 3</h3>
                            <p>Проект бревенчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brevna/4.jpg')">
                        <img src="/images/portfolio/brevna/4.jpg" alt="Бревенчатый дом 4">
                        <div class="project-info">
                            <h3>Бревенчатый дом 4</h3>
                            <p>Проект бревенчатого дома</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Брусчатый дом -->
            <div class="tab-content" id="brus">
                <div class="projects-grid">
                    <div class="project-card" onclick="openModal('/images/portfolio/brus/1.jpg')">
                        <img src="/images/portfolio/brus/1.jpg" alt="Брусчатый дом 1">
                        <div class="project-info">
                            <h3>Брусчатый дом 1</h3>
                            <p>Проект брусчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brus/2.jpg')">
                        <img src="/images/portfolio/brus/2.jpg" alt="Брусчатый дом 2">
                        <div class="project-info">
                            <h3>Брусчатый дом 2</h3>
                            <p>Проект брусчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brus/3.jpg')">
                        <img src="/images/portfolio/brus/3.jpg" alt="Брусчатый дом 3">
                        <div class="project-info">
                            <h3>Брусчатый дом 3</h3>
                            <p>Проект брусчатого дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/brus/4.jpg')">
                        <img src="/images/portfolio/brus/4.jpg" alt="Брусчатый дом 4">
                        <div class="project-info">
                            <h3>Брусчатый дом 4</h3>
                            <p>Проект брусчатого дома</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кирпичный дом -->
            <div class="tab-content" id="kirpich">
                <div class="projects-grid">
                    <div class="project-card" onclick="openModal('/images/portfolio/kirpich/1.jpg')">
                        <img src="/images/portfolio/kirpich/1.jpg" alt="Кирпичный дом 1">
                        <div class="project-info">
                            <h3>Кирпичный дом 1</h3>
                            <p>Проект кирпичного дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/kirpich/2.jpg')">
                        <img src="/images/portfolio/kirpich/2.jpg" alt="Кирпичный дом 2">
                        <div class="project-info">
                            <h3>Кирпичный дом 2</h3>
                            <p>Проект кирпичного дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/kirpich/3.jpg')">
                        <img src="/images/portfolio/kirpich/3.jpg" alt="Кирпичный дом 3">
                        <div class="project-info">
                            <h3>Кирпичный дом 3</h3>
                            <p>Проект кирпичного дома</p>
                        </div>
                    </div>
                    <div class="project-card" onclick="openModal('/images/portfolio/kirpich/4.jpg')">
                        <img src="/images/portfolio/kirpich/4.jpg" alt="Кирпичный дом 4">
                        <div class="project-info">
                            <h3>Кирпичный дом 4</h3>
                            <p>Проект кирпичного дома</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Модальное окно -->
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<style>
    .reviews-section {
        padding: 2rem 2rem;
        background: #ffffff;
    }

    .reviews-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .reviews-title {
        font-size: clamp(2rem, 4vw, 3rem);
        color: #08373d;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .review-card {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .review-author {
        font-weight: 600;
        color: #08373d;
        font-size: 1.2rem;
    }

    .review-date {
        color: #718096;
    }

    .review-content {
        color: #4a5568;
        line-height: 1.6;
    }

    .projects-section {
        padding: 1rem 2rem;
        background: #f8fafc;
    }

    .projects-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .projects-title {
        font-size: clamp(2rem, 4vw, 3rem);
        color: #08373d;
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    .projects-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .tab-button {
        padding: 0.75rem 1.5rem;
        border: none;
        background: #e2e8f0;
        color: #4a5568;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .tab-button:hover {
        background: #cbd5e0;
    }

    .tab-button.active {
        background: #08373d;
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .project-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .project-card:hover {
        transform: translateY(-5px);
    }

    .project-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .project-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
    }

    .project-info h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .project-info p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }

    /* Модальное окно */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90vh;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .close {
        position: absolute;
        right: 25px;
        top: 15px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .reviews-section,
        .projects-section {
            padding: 3rem 1rem;
        }

        .projects-tabs {
            flex-direction: column;
            align-items: stretch;
        }

        .tab-button {
            width: 100%;
            text-align: center;
        }

        .project-card img {
            height: 250px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Переключение вкладок
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Убираем активный класс у всех кнопок и контента
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Добавляем активный класс нажатой кнопке
                button.classList.add('active');
                
                // Показываем соответствующий контент
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Модальное окно
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementsByClassName('close')[0];

        window.openModal = function(imageSrc) {
            modal.style.display = "block";
            modalImg.src = imageSrc;
            document.body.style.overflow = 'hidden';
        }

        closeBtn.onclick = function() {
            modal.style.display = "none";
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.body.style.overflow = 'auto';
            }
        }

        // Закрытие по Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'block') {
                modal.style.display = "none";
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/reviews.blade.php ENDPATH**/ ?>