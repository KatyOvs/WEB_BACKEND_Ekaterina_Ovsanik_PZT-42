<?php
/**
 * Задание 4: Форма заказа пиццы
 * Демонстрация работы с различными элементами форм
 */

// Цены на пиццу
$pizza_sizes = [
    'small' => ['name' => 'Маленькая', 'price' => 250],
    'medium' => ['name' => 'Средняя', 'price' => 350],
    'large' => ['name' => 'Большая', 'price' => 450]
];

$available_toppings = [
    'cheese' => 'Сыр',
    'mushrooms' => 'Грибы',
    'sausage' => 'Колбаса',
    'olives' => 'Оливки'
];

$delivery_methods = [
    'pickup' => 'Самовывоз',
    'courier' => 'Курьером'
];

// Обработка отправленной формы
$order_processed = false;
$order_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Собираем данные заказа
    $order_data['size'] = $_POST['size'] ?? 'small';
    $order_data['toppings'] = $_POST['toppings'] ?? [];
    $order_data['comment'] = trim($_POST['comment'] ?? '');
    $order_data['delivery'] = $_POST['delivery'] ?? 'pickup';
    
    // Рассчитываем стоимость
    $total_price = $pizza_sizes[$order_data['size']]['price'];
    // Добавляем по 50 руб за каждый топпинг
    $total_price += count($order_data['toppings']) * 50;
    
    $order_data['total_price'] = $total_price;
    $order_processed = true;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ пиццы</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        .radio-group, .checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; }
        .radio-group label, .checkbox-group label { font-weight: normal; margin-right: 15px; display: inline-flex; align-items: center; }
        textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px; }
        select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: white; }
        button { background-color: #dc3545; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #c82333; }
        .order-result { background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-top: 30px; }
        .order-result h3 { margin-top: 0; color: #333; }
        .price { font-size: 20px; color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🍕 Заказ пиццы</h1>
    
    <form method="POST" action="">
        <!-- Размер пиццы (радиокнопки) -->
        <div class="form-group">
            <label>Выберите размер:</label>
            <div class="radio-group">
                <?php foreach ($pizza_sizes as $key => $size): ?>
                <label>
                    <input type="radio" name="size" value="<?php echo $key; ?>" 
                        <?php echo ($key == 'medium') ? 'checked' : ''; ?>>
                    <?php echo $size['name']; ?> (<?php echo $size['price']; ?> руб.)
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Топпинги (чекбоксы) -->
        <div class="form-group">
            <label>Дополнительные топпинги (по 50 руб.):</label>
            <div class="checkbox-group">
                <?php foreach ($available_toppings as $key => $topping): ?>
                <label>
                    <input type="checkbox" name="toppings[]" value="<?php echo $key; ?>">
                    <?php echo $topping; ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Комментарий -->
        <div class="form-group">
            <label for="comment">Комментарий к заказу:</label>
            <textarea id="comment" name="comment" placeholder="Особые пожелания..."></textarea>
        </div>
        
        <!-- Способ доставки -->
        <div class="form-group">
            <label for="delivery">Способ доставки:</label>
            <select id="delivery" name="delivery">
                <?php foreach ($delivery_methods as $key => $method): ?>
                <option value="<?php echo $key; ?>"><?php echo $method; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Оформить заказ</button>
    </form>
    
    <?php if ($order_processed): ?>
    <div class="order-result">
        <h3>✅ Ваш заказ принят!</h3>
        
        <p><strong>Размер пиццы:</strong> 
            <?php echo $pizza_sizes[$order_data['size']]['name']; ?> 
            (<?php echo $pizza_sizes[$order_data['size']]['price']; ?> руб.)
        </p>
        
        <p><strong>Выбранные топпинги:</strong>
            <?php if (empty($order_data['toppings'])): ?>
                не выбраны
            <?php else: ?>
                <?php 
                $selected_toppings = [];
                foreach ($order_data['toppings'] as $topping) {
                    if (isset($available_toppings[$topping])) {
                        $selected_toppings[] = $available_toppings[$topping];
                    }
                }
                echo implode(', ', $selected_toppings);
                ?>
            <?php endif; ?>
        </p>
        
        <?php if (!empty($order_data['comment'])): ?>
            <p><strong>Комментарий:</strong> <?php echo htmlspecialchars($order_data['comment']); ?></p>
        <?php endif; ?>
        
        <p><strong>Способ доставки:</strong> <?php echo $delivery_methods[$order_data['delivery']]; ?></p>
        
        <p class="price">Итого: <?php echo $order_data['total_price']; ?> руб.</p>
    </div>
    <?php endif; ?>
</body>
</html>