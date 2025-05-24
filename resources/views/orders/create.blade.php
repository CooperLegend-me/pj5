@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создание заказа</h1>

    <form action="{{ route('orders.store') }}" method="POST" class="order-form">
        @csrf

        <div class="form-section">
            <h2>Основные параметры</h2>
            
            <div class="form-group">
                <label for="area">Площадь дома (кв. м)</label>
                <input type="number" id="area" name="area" class="form-control" required min="20" max="1000" value="{{ old('area') }}">
                @error('area')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="floors">Количество этажей</label>
                <select id="floors" name="floors" class="form-control" required>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('floors') == $i ? 'selected' : '' }}>{{ $i }} этаж(ей)</option>
                    @endfor
                </select>
                @error('floors')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="house_type">Тип дома</label>
                <select id="house_type" name="house_type" class="form-control" required>
                    <option value="standard" {{ old('house_type') == 'standard' ? 'selected' : '' }}>Стандартный</option>
                    <option value="cottage" {{ old('house_type') == 'cottage' ? 'selected' : '' }}>Коттедж</option>
                    <option value="villa" {{ old('house_type') == 'villa' ? 'selected' : '' }}>Вилла</option>
                    <option value="mansion" {{ old('house_type') == 'mansion' ? 'selected' : '' }}>Особняк</option>
                </select>
                @error('house_type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h2>Конструктивные особенности</h2>

            <div class="form-group">
                <label for="roof_type">Тип крыши</label>
                <select id="roof_type" name="roof_type" class="form-control" required>
                    <option value="flat" {{ old('roof_type') == 'flat' ? 'selected' : '' }}>Плоская</option>
                    <option value="gable" {{ old('roof_type') == 'gable' ? 'selected' : '' }}>Скатная</option>
                    <option value="hip" {{ old('roof_type') == 'hip' ? 'selected' : '' }}>Шатровая</option>
                    <option value="mansard" {{ old('roof_type') == 'mansard' ? 'selected' : '' }}>Мансардная</option>
                </select>
                @error('roof_type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="wall_material">Материал стен</label>
                <select id="wall_material" name="wall_material" class="form-control" required>
                    <option value="brick" {{ old('wall_material') == 'brick' ? 'selected' : '' }}>Кирпич</option>
                    <option value="wood" {{ old('wall_material') == 'wood' ? 'selected' : '' }}>Дерево</option>
                    <option value="concrete" {{ old('wall_material') == 'concrete' ? 'selected' : '' }}>Бетон</option>
                    <option value="foam" {{ old('wall_material') == 'foam' ? 'selected' : '' }}>Пеноблоки</option>
                    <option value="aeratedConcrete" {{ old('wall_material') == 'aeratedConcrete' ? 'selected' : '' }}>Газобетон</option>
                    <option value="sipPanels" {{ old('wall_material') == 'sipPanels' ? 'selected' : '' }}>СИП-панели</option>
                </select>
                @error('wall_material')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h2>Дополнительные параметры</h2>

            <div class="form-group">
                <label for="foundation_type">Тип фундамента</label>
                <select id="foundation_type" name="foundation_type" class="form-control">
                    <option value="strip" {{ old('foundation_type') == 'strip' ? 'selected' : '' }}>Ленточный</option>
                    <option value="pile" {{ old('foundation_type') == 'pile' ? 'selected' : '' }}>Свайный</option>
                    <option value="slab" {{ old('foundation_type') == 'slab' ? 'selected' : '' }}>Плита</option>
                    <option value="column" {{ old('foundation_type') == 'column' ? 'selected' : '' }}>Столбчатый</option>
                </select>
            </div>

            <div class="form-group">
                <label for="finishing_material">Материал отделки</label>
                <select id="finishing_material" name="finishing_material" class="form-control">
                    <option value="plaster" {{ old('finishing_material') == 'plaster' ? 'selected' : '' }}>Штукатурка</option>
                    <option value="paint" {{ old('finishing_material') == 'paint' ? 'selected' : '' }}>Краска</option>
                    <option value="tile" {{ old('finishing_material') == 'tile' ? 'selected' : '' }}>Плитка</option>
                    <option value="woodPanel" {{ old('finishing_material') == 'woodPanel' ? 'selected' : '' }}>Деревянные панели</option>
                </select>
            </div>
        </div>

        <div class="form-section">
            <h2>Дополнительные услуги</h2>

            <div class="checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="additional_services[]" value="designProject" {{ in_array('designProject', old('additional_services', [])) ? 'checked' : '' }}>
                    Проектирование (+50 000 руб.)
                </label>

                <label class="checkbox-label">
                    <input type="checkbox" name="additional_services[]" value="landscapeDesign" {{ in_array('landscapeDesign', old('additional_services', [])) ? 'checked' : '' }}>
                    Ландшафтный дизайн (+75 000 руб.)
                </label>

                <label class="checkbox-label">
                    <input type="checkbox" name="additional_services[]" value="interiorDesign" {{ in_array('interiorDesign', old('additional_services', [])) ? 'checked' : '' }}>
                    Дизайн интерьера (+60 000 руб.)
                </label>

                <label class="checkbox-label">
                    <input type="checkbox" name="additional_services[]" value="smartHome" {{ in_array('smartHome', old('additional_services', [])) ? 'checked' : '' }}>
                    Умный дом (+120 000 руб.)
                </label>
            </div>
        </div>

        <div class="form-section">
            <h2>Условия строительства</h2>

            <div class="form-group">
                <label for="construction_time">Срок строительства (мес.)</label>
                <select id="construction_time" name="construction_time" class="form-control" required>
                    <option value="6" {{ old('construction_time') == '6' ? 'selected' : '' }}>6 месяцев</option>
                    <option value="9" {{ old('construction_time') == '9' ? 'selected' : '' }}>9 месяцев</option>
                    <option value="12" {{ old('construction_time') == '12' ? 'selected' : '' }}>12 месяцев</option>
                    <option value="18" {{ old('construction_time') == '18' ? 'selected' : '' }}>18 месяцев</option>
                </select>
                @error('construction_time')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="payment_method">Способ оплаты</label>
                <select id="payment_method" name="payment_method" class="form-control" required>
                    <option value="full" {{ old('payment_method') == 'full' ? 'selected' : '' }}>Полная предоплата</option>
                    <option value="installment" {{ old('payment_method') == 'installment' ? 'selected' : '' }}>Рассрочка</option>
                    <option value="bankCredit" {{ old('payment_method') == 'bankCredit' ? 'selected' : '' }}>Банковский кредит</option>
                    <option value="stagePayment" {{ old('payment_method') == 'stagePayment' ? 'selected' : '' }}>Поэтапная оплата</option>
                </select>
                @error('payment_method')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Создать заказ</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.order-form {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h2 {
    margin-bottom: 1.5rem;
    color: #333;
    font-size: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
}

.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #5a6268;
}
</style>
@endsection 