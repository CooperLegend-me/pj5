// Ждем полной загрузки DOM и всех ресурсов
window.addEventListener('load', function() {
    console.log('Window loaded, initializing review images...');
    
    // Создаем модальное окно
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="" alt="Увеличенное фото" class="modal-image">
        </div>
    `;
    document.body.appendChild(modal);

    // Находим элементы модального окна
    const modalImg = modal.querySelector('.modal-image');
    const closeBtn = modal.querySelector('.close');

    // Функция для открытия модального окна
    function openModal(imgSrc) {
        modal.style.display = 'block';
        modalImg.src = imgSrc;
        document.body.style.overflow = 'hidden';
    }

    // Функция для закрытия модального окна
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Закрытие модального окна при клике на крестик
    closeBtn.addEventListener('click', closeModal);

    // Закрытие модального окна при клике вне изображения
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Закрытие модального окна при нажатии Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Создаем модальное окно
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <img class="modal-image" src="" alt="Увеличенное изображение">
        </div>
    `;
    document.body.appendChild(modal);

    // Находим все изображения в проектах
    const projectImages = document.querySelectorAll('.project img');
    
    // Добавляем обработчики кликов
    projectImages.forEach(img => {
        img.addEventListener('click', function() {
            const modalImg = modal.querySelector('.modal-image');
            modalImg.src = this.src;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Блокируем прокрутку страницы
        });
    });

    // Закрытие модального окна
    const closeBtn = modal.querySelector('.close');
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Разблокируем прокрутку страницы
    });

    // Закрытие по клику вне изображения
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Закрытие по Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
}); 