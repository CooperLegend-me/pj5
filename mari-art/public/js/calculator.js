function calculateCost() {
    // Получаем значения из формы
    const area = document.getElementById('area').value;
    const floors = document.getElementById('floors').value;
    const houseType = document.getElementById('houseType').value;
    const roofType = document.getElementById('roofType').value;
    const foundationType = document.getElementById('foundationType').value;
    const finishingMaterial = document.getElementById('finishingMaterial').value;
    const windowsType = document.getElementById('windowsType').value;
    const heatingType = document.getElementById('heatingType').value;
    const sewageType = document.getElementById('sewageType').value;
    const constructionTime = document.getElementById('constructionTime').value;

    // Получаем выбранные дополнительные услуги
    const additionalServices = [];
    if (document.getElementById('designProject').checked) additionalServices.push('Проектирование');
    if (document.getElementById('landscapeDesign').checked) additionalServices.push('Ландшафтный дизайн');
    if (document.getElementById('interiorDesign').checked) additionalServices.push('Дизайн интерьера');
    if (document.getElementById('smartHome').checked) additionalServices.push('Умный дом');
    if (document.getElementById('securitySystem').checked) additionalServices.push('Охранная система');
    if (document.getElementById('fireplace').checked) additionalServices.push('Камин');

    // Базовые цены
    const basePrice = area * 15000; // 15000 руб за кв.м
    const floorMultiplier = floors * 0.8;
    const houseTypeMultiplier = {
        'brevna': 1.2,
        'kirpich': 1.5,
        'brus': 1.3
    }[houseType];

    // Расчет стоимости
    let totalCost = basePrice * floorMultiplier * houseTypeMultiplier;

    // Добавляем стоимость дополнительных услуг
    const serviceCosts = {
        'Проектирование': 50000,
        'Ландшафтный дизайн': 75000,
        'Дизайн интерьера': 60000,
        'Умный дом': 120000,
        'Охранная система': 45000,
        'Камин': 85000
    };

    additionalServices.forEach(service => {
        totalCost += serviceCosts[service];
    });

    // Обновляем результаты
    document.getElementById('resultArea').textContent = `${area} кв.м`;
    document.getElementById('resultFloors').textContent = floors;
    document.getElementById('resultHouseType').textContent = document.getElementById('houseType').options[document.getElementById('houseType').selectedIndex].text;
    document.getElementById('resultRoof').textContent = document.getElementById('roofType').options[document.getElementById('roofType').selectedIndex].text;
    document.getElementById('resultFoundation').textContent = document.getElementById('foundationType').options[document.getElementById('foundationType').selectedIndex].text;
    document.getElementById('resultFinishing').textContent = document.getElementById('finishingMaterial').options[document.getElementById('finishingMaterial').selectedIndex].text;
    document.getElementById('resultWindows').textContent = document.getElementById('windowsType').options[document.getElementById('windowsType').selectedIndex].text;

    // Добавляем отображение стоимости
    const resultDiv = document.getElementById('result');
    const costElement = document.createElement('div');
    costElement.className = 'maric-result-item';
    costElement.innerHTML = `
        <span class="maric-result-label">Итоговая стоимость:</span>
        <span class="maric-result-value" style="color: #28a745; font-weight: bold;">${totalCost.toLocaleString()} руб.</span>
    `;
    resultDiv.appendChild(costElement);

    // Показываем результаты
    resultDiv.style.display = 'block';

    // Создаем объект с данными расчета
    const calculationData = {
        area,
        floors,
        house_type: houseType,
        roof_type: roofType,
        foundation_type: foundationType,
        finishing_material: finishingMaterial,
        windows_type: windowsType,
        heating_type: heatingType,
        sewage_type: sewageType,
        construction_time: constructionTime,
        additional_services: additionalServices
    };

    // Проверяем авторизацию и добавляем кнопку отправки заказа
    fetch('/api/check-auth')
        .then(response => response.json())
        .then(data => {
            // Удаляем существующие кнопки и сообщения
            const existingSubmitButton = document.getElementById('submitOrder');
            const existingAuthMessage = document.querySelector('.auth-message');
            if (existingSubmitButton) existingSubmitButton.remove();
            if (existingAuthMessage) existingAuthMessage.remove();

            if (data.authenticated) {
                const button = document.createElement('button');
                button.id = 'submitOrder';
                button.className = 'maric-form-button primary';
                button.textContent = 'Отправить заказ';
                button.onclick = () => submitOrder(calculationData, totalCost);
                resultDiv.appendChild(button);
            } else {
                const authMessage = document.createElement('div');
                authMessage.className = 'auth-message';
                authMessage.innerHTML = `
                    <p>Для отправки заказа необходимо <a href="/login">войти в систему</a></p>
                `;
                resultDiv.appendChild(authMessage);
            }
        })
        .catch(error => {
            console.error('Error checking auth status:', error);
        });
}

function submitOrder(calculationData, totalCost) {
    // Получаем CSRF-токен из мета-тега
    const token = document.querySelector('meta[name="csrf-token"]');
    
    if (!token) {
        console.error('CSRF token not found');
        alert('Ошибка безопасности. Пожалуйста, обновите страницу и попробуйте снова.');
        return;
    }

    const csrfToken = token.getAttribute('content');
    
    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            house_type: calculationData.house_type,
            roof_type: calculationData.roof_type,
            foundation_type: calculationData.foundation_type,
            finishing_material: calculationData.finishing_material,
            windows_type: calculationData.windows_type,
            heating_type: calculationData.heating_type,
            sewage_type: calculationData.sewage_type,
            construction_time: calculationData.construction_time,
            additional_services: calculationData.additional_services,
            total_cost: totalCost
        })
    })
    .then(response => {
        if (response.headers.get('content-type')?.includes('application/json')) {
            return response.json().then(data => {
        if (!response.ok) {
                    throw new Error(data.message || 'Произошла ошибка при сохранении заказа');
        }
                return data;
            });
        } else {
            throw new Error('Неверный формат ответа от сервера');
        }
    })
    .then(data => {
        if (data.success) {
            // Перенаправляем на страницу заказов
            window.location.href = data.redirect;
        } else {
            throw new Error(data.message || 'Произошла ошибка при сохранении заказа');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message === 'Unauthorized') {
            alert('Для создания заказа необходимо авторизоваться');
            window.location.href = '/login';
        } else {
            alert(error.message || 'Произошла ошибка при сохранении заказа. Пожалуйста, попробуйте еще раз.');
        }
    });
}

function resetForm() {
    document.querySelectorAll('input, select').forEach(element => {
        if (element.type === 'checkbox') {
            element.checked = false;
        } else if (element.type === 'number') {
            element.value = '';
        } else if (element.tagName === 'SELECT') {
            element.selectedIndex = 0;
        }
    });
    const resultDiv = document.getElementById('result');
    resultDiv.style.display = 'none';
    // Очищаем содержимое блока результатов
    while (resultDiv.firstChild) {
        resultDiv.removeChild(resultDiv.firstChild);
    }
}

function saveDraft() {
    // Здесь будет логика сохранения черновика
    alert('Функция сохранения черновика будет доступна после авторизации');
} 