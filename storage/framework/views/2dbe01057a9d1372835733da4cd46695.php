<?php $__env->startSection('content'); ?>
<div class="maric-bg-wrapper">
    <div class="maric-bg-image"></div>
    <div class="maric-bg-overlay"></div>
</div>

<div class="maric-calc-wrapper">
    <div class="maric-calc-container">
        <div class="maric-calc-header">
            <h1 class="maric-calc-title">Калькулятор строительства дома</h1>
            <p class="maric-calc-subtitle">Рассчитайте точную стоимость вашего будущего дома</p>
        </div>
        
        <div id="basicTab" class="maric-tab-content" style="display: block;">
            <div class="maric-form-group full-width">
                <label for="area" class="maric-form-label">Площадь дома (кв. м)</label>
                <input type="number" id="area" class="maric-form-input" required min="20" max="1000" placeholder="Например: 120">
            </div>
            
            <div class="maric-form-group">
                <label for="floors" class="maric-form-label">Количество этажей</label>
                <select id="floors" class="maric-form-select" required>
                    <option value="1">1 этаж</option>
                    <option value="2">2 этажа</option>
                    <option value="3">3 этажа</option>
                    <option value="4">4 этажа</option>
                    <option value="5">5 этажей</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="houseType" class="maric-form-label">Тип дома</label>
                <select id="houseType" class="maric-form-select">
                    <option value="brevna">Бревенчатый дом</option>
                    <option value="kirpich">Кирпичный дом</option>
                    <option value="brus">Брусчатый дом</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="roofType" class="maric-form-label">Тип крыши</label>
                <select id="roofType" class="maric-form-select">
                    <option value="flat">Плоская</option>
                    <option value="gable">Скатная</option>
                    <option value="hip">Шатровая</option>
                    <option value="mansard">Мансардная</option>
                </select>
            </div>
        </div>
        
        <div id="advancedTab" class="maric-tab-content">
            <div class="maric-form-group">
                <label for="foundationType" class="maric-form-label">Тип фундамента</label>
                <select id="foundationType" class="maric-form-select">
                    <option value="strip">Ленточный</option>
                    <option value="pile">Свайный</option>
                    <option value="slab">Плита</option>
                    <option value="column">Столбчатый</option>
                    <option value="deepStrip">Глубокозаглубленный ленточный</option>
                    <option value="pileGrillage">Свайно-ростверковый</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="finishingMaterial" class="maric-form-label">Материал отделки</label>
                <select id="finishingMaterial" class="maric-form-select">
                    <option value="plaster">Штукатурка</option>
                    <option value="paint">Краска</option>
                    <option value="tile">Плитка</option>
                    <option value="woodPanel">Деревянные панели</option>
                    <option value="stone">Камень</option>
                    <option value="ventilatedFacade">Вентилируемый фасад</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="windowsType" class="maric-form-label">Тип окон</label>
                <select id="windowsType" class="maric-form-select">
                    <option value="plastic">Пластиковые</option>
                    <option value="wooden">Деревянные</option>
                    <option value="aluminum">Алюминиевые</option>
                    <option value="energySaving">Энергосберегающие</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="heatingType" class="maric-form-label">Тип отопления</label>
                <select id="heatingType" class="maric-form-select">
                    <option value="gas">Газовое</option>
                    <option value="electric">Электрическое</option>
                    <option value="solidFuel">Твердотопливное</option>
                    <option value="heatPump">Тепловой насос</option>
                </select>
            </div>
            
            <div class="maric-form-group">
                <label for="sewageType" class="maric-form-label">Канализация</label>
                <select id="sewageType" class="maric-form-select">
                    <option value="central">Центральная</option>
                    <option value="septic">Септик</option>
                    <option value="biological">Биологическая очистка</option>
                </select>
            </div>
        </div>
        
        <div id="servicesTab" class="maric-tab-content">
            <div class="maric-form-group full-width">
                <label class="maric-form-label">Дополнительные услуги</label>
                <div class="maric-checkbox-group">
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="designProject" value="designProject"> Проектирование
                        <span class="maric-checkbox-cost">+50 000 руб.</span>
                    </label>
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="landscapeDesign" value="landscapeDesign"> Ландшафтный дизайн
                        <span class="maric-checkbox-cost">+75 000 руб.</span>
                    </label>
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="interiorDesign" value="interiorDesign"> Дизайн интерьера
                        <span class="maric-checkbox-cost">+60 000 руб.</span>
                    </label>
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="smartHome" value="smartHome"> Умный дом
                        <span class="maric-checkbox-cost">+120 000 руб.</span>
                    </label>
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="securitySystem" value="securitySystem"> Охранная система
                        <span class="maric-checkbox-cost">+45 000 руб.</span>
                    </label>
                    <label class="maric-checkbox-label">
                        <input type="checkbox" id="fireplace" value="fireplace"> Камин
                        <span class="maric-checkbox-cost">+85 000 руб.</span>
                    </label>
                </div>
            </div>
            
            <div class="maric-form-group full-width">
                <label for="constructionTime" class="maric-form-label">Срок строительства (мес.)</label>
                <select id="constructionTime" class="maric-form-select">
                    <option value="6">6 месяцев</option>
                    <option value="9" selected>9 месяцев</option>
                    <option value="12">12 месяцев</option>
                    <option value="18">18 месяцев</option>
                    <option value="24">24 месяца</option>
                    <option value="custom">Индивидуальный график</option>
                </select>
            </div>
        </div>
        
        <div class="maric-form-actions">
            <button type="button" class="maric-form-button secondary" onclick="resetForm()">Сбросить</button>
            <button type="button" class="maric-form-button" onclick="calculateCost()">Рассчитать стоимость</button>
        </div>

        <div class="maric-results" id="result" style="display: none;">
            <h3 class="maric-results-title">Результаты расчета</h3>
            <div class="maric-results-grid">
                <div class="maric-result-item">
                    <span class="maric-result-label">Площадь дома:</span>
                    <span class="maric-result-value" id="resultArea">0 кв.м</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Этажность:</span>
                    <span class="maric-result-value" id="resultFloors">0</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Тип дома:</span>
                    <span class="maric-result-value" id="resultHouseType">-</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Тип крыши:</span>
                    <span class="maric-result-value" id="resultRoof">-</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Фундамент:</span>
                    <span class="maric-result-value" id="resultFoundation">-</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Отделка:</span>
                    <span class="maric-result-value" id="resultFinishing">-</span>
                </div>
                <div class="maric-result-item">
                    <span class="maric-result-label">Окна:</span>
                    <span class="maric-result-value" id="resultWindows">-</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/styles1.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/styles2.css')); ?>">
<style>
.auth-message {
    margin-top: 1rem;
    padding: 1rem;
    background: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 8px;
    color: #856404;
}

.auth-message a {
    color: #0056b3;
    text-decoration: none;
    font-weight: 500;
}

.auth-message a:hover {
    text-decoration: underline;
}

.maric-form-button.primary {
    background: #28a745;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 1rem;
}

.maric-form-button.primary:hover {
    background: #218838;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/calculator.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sitni\OneDrive\Рабочий стол\saitrabotaG — копия\mari-art\resources\views/calculator.blade.php ENDPATH**/ ?>