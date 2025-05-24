document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing burger menu...');

    // Получаем элементы
    const burgerMenu = document.getElementById('burger-menu');
    const navContainer = document.querySelector('.nav-container');
    const body = document.body;

    console.log('Burger menu element:', burgerMenu);
    console.log('Nav container element:', navContainer);

    // Проверяем наличие элементов
    if (!burgerMenu || !navContainer) {
        console.error('Burger menu elements not found');
        return;
    }

    // Функция для переключения меню
    function toggleMenu(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        burgerMenu.classList.toggle('active');
        navContainer.classList.toggle('active');
        body.classList.toggle('menu-open');
        
        console.log('Menu toggled:', {
            burgerActive: burgerMenu.classList.contains('active'),
            navActive: navContainer.classList.contains('active'),
            bodyMenuOpen: body.classList.contains('menu-open')
        });
    }

    // Обработчик клика по бургер-меню
    burgerMenu.addEventListener('click', toggleMenu);

    // Закрытие меню при клике на пункт меню
    const menuItems = document.querySelectorAll('.nav-list-12 a, .nav-button');
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            if (window.innerWidth <= 760) {
                toggleMenu();
            }
        });
    });

    // Обработка формы выхода
    const logoutForm = document.querySelector('.logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', () => {
            if (window.innerWidth <= 760) {
                toggleMenu();
            }
        });
    }

    // Закрытие меню при клике вне меню
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 760) {
            const isMenuOpen = navContainer.classList.contains('active');
            const clickedOutside = !navContainer.contains(e.target) && !burgerMenu.contains(e.target);
            
            if (isMenuOpen && clickedOutside) {
                toggleMenu();
            }
        }
    });

    // Закрытие меню при нажатии Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navContainer.classList.contains('active')) {
            toggleMenu();
        }
    });

    // Обработка изменения размера окна
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 760 && navContainer.classList.contains('active')) {
                toggleMenu();
            }
        }, 250);
    });

    // Модальное окно для изображений
    document.querySelectorAll('.project-slider .project img').forEach(img => {
        img.addEventListener('click', function() {
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.innerHTML = `
                <span class="close">&times;</span>
                <img class="modal-content" src="${this.src}" alt="${this.alt}">
            `;
            document.body.appendChild(modal);
            
            modal.style.display = "block";
            
            modal.querySelector('.close').onclick = function() {
                modal.style.display = "none";
                modal.remove();
            }
            
            modal.onclick = function(e) {
                if (e.target === modal) {
                    modal.style.display = "none";
                    modal.remove();
                }
            }
        });
    });

    // Инициализация меню при загрузке
    if (window.innerWidth <= 760) {
        navContainer.style.display = 'none';
        setTimeout(() => {
            navContainer.style.display = '';
        }, 100);
    }

    console.log('Burger menu initialized successfully');
});