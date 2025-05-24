// Обработчик клика по логотипу
$(document).ready(function() {
    $('.logo-12').click(function() {
        window.location.href = 'index.html';
    });
    
    // Маска для телефона
    $('#phone').inputmask('+7 (999) 999-99-99');
});

// Функции для работы с калькулятором
function openTab(tabId) {
    // Скрыть все вкладки
    document.querySelectorAll('.maric-tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Показать выбранную вкладку
    document.getElementById(tabId).style.display = 'block';
    
    // Обновить активные кнопки вкладок
    document.querySelectorAll('.maric-tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    event.currentTarget.classList.add('active');
}

function calculateCost() {
    // Получаем значения из формы
    const area = parseInt(document.getElementById('area').value);
    const floors = parseInt(document.getElementById('floors').value);
    const houseType = document.getElementById('houseType').value;
    const roofType = document.getElementById('roofType').value;
    const wallMaterial = document.getElementById('wallMaterial').value;
    const foundationType = document.getElementById('foundationType').value;
    const finishingMaterial = document.getElementById('finishingMaterial').value;
    const windowsType = document.getElementById('windowsType').value;
    const heatingType = document.getElementById('heatingType').value;
    const sewageType = document.getElementById('sewageType').value;
    const constructionTime = document.getElementById('constructionTime').value;
    const paymentMethod = document.getElementById('paymentMethod').value;
    
    // Получаем выбранные дополнительные услуги
    const services = [];
    const serviceElements = document.querySelectorAll('.maric-checkbox-group input[type="checkbox"]:checked');
    serviceElements.forEach(service => {
        services.push(service.id);
    });
    
    // Коэффициенты стоимости
    const baseCost = 30000; // Базовая стоимость за кв.м
    
    // Множители для разных типов домов
    const houseTypeMultipliers = {
        standard: 1.0,
        cottage: 1.3,
        villa: 1.8,
        mansion: 2.5
    };
    
    // Множители за этажность (нелинейная зависимость)
    const floorMultipliers = {
        1: 1.0,
        2: 1.8,
        3: 2.5,
        4: 3.1,
        5: 3.6
    };
    
    // Множители для крыш
    const roofCosts = {
        flat: 1.0,
        gable: 1.2,
        hip: 1.4,
        mansard: 1.8
    };
    
    // Множители для материалов стен
    const wallCosts = {
        brick: 1.5,
        wood: 1.2,
        concrete: 1.3,
        foam: 1.0,
        aeratedConcrete: 1.1,
        sipPanels: 0.9
    };
    
    // Множители для фундаментов
    const foundationCosts = {
        strip: 1.2,
        pile: 1.0,
        slab: 1.5,
        column: 0.8,
        deepStrip: 1.4,
        pileGrillage: 1.3
    };
    
    // Множители для отделки
    const finishingCosts = {
        plaster: 1.0,
        paint: 0.8,
        tile: 1.5,
        woodPanel: 1.8,
        stone: 2.2,
        ventilatedFacade: 1.7
    };
    
    // Множители для окон
    const windowsCosts = {
        plastic: 1.0,
        wooden: 1.3,
        aluminum: 1.2,
        energySaving: 1.5
    };
    
    // Множители для отопления
    const heatingCosts = {
        gas: 1.2,
        electric: 1.0,
        solidFuel: 0.9,
        heatPump: 1.8
    };
    
    // Множители для канализации
    const sewageCosts = {
        central: 1.0,
        septic: 1.3,
        biological: 1.8
    };
    
    // Стоимость дополнительных услуг
    const servicesCosts = {
        designProject: 50000,
        landscapeDesign: 75000,
        interiorDesign: 60000,
        smartHome: 120000,
        securitySystem: 45000,
        fireplace: 85000
    };
    
    // Множители сроков строительства
    const timeMultipliers = {
        6: 1.2,
        9: 1.0,
        12: 0.9,
        18: 0.85,
        24: 0.8,
        custom: 1.1
    };
    
    // Скидки за способ оплаты
    const paymentDiscounts = {
        full: 0.05,
        installment: 0,
        bankCredit: 0.02,
        stagePayment: 0.03
    };
    
    // Перевод значений в читаемый вид
    const houseTypeNames = {
        standard: "Стандартный",
        cottage: "Коттедж",
        villa: "Вилла",
        mansion: "Особняк"
    };
    
    const roofNames = {
        flat: "Плоская",
        gable: "Скатная",
        hip: "Шатровая",
        mansard: "Мансардная"
    };
    
    const wallNames = {
        brick: "Кирпич",
        wood: "Дерево",
        concrete: "Бетон",
        foam: "Пеноблоки",
        aeratedConcrete: "Газобетон",
        sipPanels: "СИП-панели"
    };
    
    const foundationNames = {
        strip: "Ленточный",
        pile: "Свайный",
        slab: "Плита",
        column: "Столбчатый",
        deepStrip: "Глубокозаглубленный ленточный",
        pileGrillage: "Свайно-ростверковый"
    };
    
    const finishingNames = {
        plaster: "Штукатурка",
        paint: "Краска",
        tile: "Плитка",
        woodPanel: "Деревянные панели",
        stone: "Камень",
        ventilatedFacade: "Вентилируемый фасад"
    };
    
    const windowsNames = {
        plastic: "Пластиковые",
        wooden: "Деревянные",
        aluminum: "Алюминиевые",
        energySaving: "Энергосберегающие"
    };
    
    const heatingNames = {
        gas: "Газовое",
        electric: "Электрическое",
        solidFuel: "Твердотопливное",
        heatPump: "Тепловой насос"
    };
    
    const sewageNames = {
        central: "Центральная",
        septic: "Септик",
        biological: "Биологическая очистка"
    };
    
    const serviceNames = {
        designProject: "Проектирование",
        landscapeDesign: "Ландшафтный дизайн",
        interiorDesign: "Дизайн интерьера",
        smartHome: "Умный дом",
        securitySystem: "Охранная система",
        fireplace: "Камин"
    };
    
    // Расчет базовой стоимости
    let totalCost = area * baseCost;
    
    // Применяем множители
    totalCost *= houseTypeMultipliers[houseType] || 1;
    totalCost *= floorMultipliers[floors] || 1;
    totalCost *= roofCosts[roofType] || 1;
    totalCost *= wallCosts[wallMaterial] || 1;
    totalCost *= foundationCosts[foundationType] || 1;
    totalCost *= finishingCosts[finishingMaterial] || 1;
    totalCost *= windowsCosts[windowsType] || 1;
    totalCost *= heatingCosts[heatingType] || 1;
    totalCost *= sewageCosts[sewageType] || 1;
    totalCost *= timeMultipliers[constructionTime] || 1;
    
    // Добавляем стоимость дополнительных услуг
    let servicesCost = 0;
    let servicesList = [];
    
    serviceElements.forEach(service => {
        servicesCost += servicesCosts[service.id] || 0;
        servicesList.push(serviceNames[service.id]);
    });
    
    totalCost += servicesCost;
    
    // Рассчитываем скидку
    const discount = paymentDiscounts[paymentMethod] || 0;
    const discountAmount = totalCost * discount;
    const finalCost = totalCost - discountAmount;
    
    // Округление
    totalCost = Math.round(totalCost / 1000) * 1000;
    const roundedFinalCost = Math.round(finalCost / 1000) * 1000;
    const roundedDiscount = Math.round(discountAmount / 1000) * 1000;
    
    // Рассчитываем варианты оплаты
    const installment12 = Math.round(finalCost / 12 / 1000) * 1000;
    const credit60 = Math.round((finalCost * 1.089) / 60 / 1000) * 1000;
    
    // Отображение результатов
    document.getElementById('resultArea').textContent = area + ' кв.м';
    document.getElementById('resultFloors').textContent = floors;
    document.getElementById('resultHouseType').textContent = houseTypeNames[houseType];
    document.getElementById('resultRoof').textContent = roofNames[roofType];
    document.getElementById('resultWalls').textContent = wallNames[wallMaterial];
    document.getElementById('resultFoundation').textContent = foundationNames[foundationType];
    document.getElementById('resultFinishing').textContent = finishingNames[finishingMaterial];
    document.getElementById('resultWindows').textContent = windowsNames[windowsType];
    document.getElementById('resultHeating').textContent = heatingNames[heatingType];
    document.getElementById('resultSewage').textContent = sewageNames[sewageType];
    document.getElementById('resultServices').textContent = servicesList.join(', ') || 'Нет';
    document.getElementById('resultTotal').textContent = totalCost.toLocaleString('ru-RU') + ' руб.';
    document.getElementById('resultDiscount').textContent = `${(discount * 100)}% (${roundedDiscount.toLocaleString('ru-RU')} руб.)`;
    document.getElementById('resultFinal').textContent = roundedFinalCost.toLocaleString('ru-RU') + ' руб.';
    
    // Отображаем варианты оплаты
    document.getElementById('paymentFull').textContent = (roundedFinalCost * 0.95).toLocaleString('ru-RU') + ' руб.';
    document.getElementById('paymentInstallment').textContent = installment12.toLocaleString('ru-RU') + ' руб./мес';
    document.getElementById('paymentCredit').textContent = credit60.toLocaleString('ru-RU') + ' руб./мес';
    
    // Показываем результаты
    document.getElementById('result').style.display = 'block';
    
    // Прокрутка к результатам
    document.getElementById('result').scrollIntoView({ behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('constructionForm').reset();
    document.getElementById('result').style.display = 'none';
    document.getElementById('contactForm').style.display = 'none';
}

function showContactForm() {
    document.getElementById('contactForm').style.display = 'block';
    document.getElementById('contactForm').scrollIntoView({ behavior: 'smooth' });
}

function hideContactForm() {
    document.getElementById('contactForm').style.display = 'none';
}

function submitContact() {
    const fullName = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const comment = document.getElementById('comment').value;
    
    if (!fullName || !email || !phone) {
        alert('Пожалуйста, заполните обязательные поля');
        return;
    }
    
    // Здесь можно добавить код для отправки данных на сервер
    alert('Ваш расчет сохранен! Мы свяжемся с вами в ближайшее время.');
    hideContactForm();
}

function printCalculation() {
    window.print();
}

function filterCalculations(filter) {
    alert('Фильтрация сохраненных расчетов будет реализована позже');
}