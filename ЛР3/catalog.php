<?php
/**
 * Задание 5: Фильтрация товаров через GET-запросы
 * Каталог товаров с фильтрацией по цене и категории
 */

// Массив товаров
$products = [
    ['name' => 'Ноутбук ASUS', 'category' => 'электроника', 'price' => 55000],
    ['name' => 'Книга PHP для начинающих', 'category' => 'книги', 'price' => 1200],
    ['name' => 'Мышь беспроводная', 'category' => 'электроника', 'price' => 1500],
    ['name' => 'Клавиатура механическая', 'category' => 'электроника', 'price' => 3500],
    ['name' => 'Монитор 24"', 'category' => 'электроника', 'price' => 18000],
    ['name' => 'Книга "JavaScript для профессионалов"', 'category' => 'книги', 'price' => 2100],
    ['name' => 'Наушники', 'category' => 'электроника', 'price' => 2500],
    ['name' => 'Книга "Алгоритмы на Python"', 'category' => 'книги', 'price' => 1800],
    ['name' => 'Внешний жесткий диск', 'category' => 'электроника', 'price' => 4200],
    ['name' => 'Книга "Война и мир"', 'category' => 'книги', 'price' => 800]
];

// Получаем уникальные категории
$categories = array_unique(array_column($products, 'category'));
sort($categories);

// Получаем параметры фильтрации из GET
$min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
$selected_category = $_GET['category'] ?? '';

// Фильтрация товаров
$filtered_products = array_filter($products, function($product) use ($min_price, $max_price, $selected_category) {
    // Фильтр по цене (мин)
    if ($min_price !== null && $product['price'] < $min_price) {
        return false;
    }
    
    // Фильтр по цене (макс)
    if ($max_price !== null && $product['price'] > $max_price) {
        return false;
    }
    
    // Фильтр по категории
    if (!empty($selected_category) && $product['category'] !== $selected_category) {
        return false;
    }
    
    return true;
});
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог товаров</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; }
        .filter-form { background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 30px; }
        .filter-row { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .filter-group { flex: 1; min-width: 150px; }
        .filter-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .filter-group input, .filter-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        tr:hover { background-color: #f5f5f5; }
        .price { font-weight: bold; color: #28a745; }
        .quick-filters { margin-top: 20px; padding: 15px; background-color: #e9ecef; border-radius: 4px; }
        .quick-filters a { display: inline-block; margin-right: 15px; color: #007bff; text-decoration: none; }
        .quick-filters a:hover { text-decoration: underline; }
        .count { margin-top: 10px; color: #6c757d; }
    </style>
</head>
<body>
    <h1>Каталог товаров</h1>
    
    <!-- Форма фильтрации (GET) -->
    <div class="filter-form">
        <form method="GET" action="">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="min_price">Мин. цена (руб.):</label>
                    <input type="number" id="min_price" name="min_price" min="0" value="<?php echo htmlspecialchars($min_price ?? ''); ?>">
                </div>
                
                <div class="filter-group">
                    <label for="max_price">Макс. цена (руб.):</label>
                    <input type="number" id="max_price" name="max_price" min="0" value="<?php echo htmlspecialchars($max_price ?? ''); ?>">
                </div>
                
                <div class="filter-group">
                    <label for="category">Категория:</label>
                    <select id="category" name="category">
                        <option value="">Все категории</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category); ?>" 
                                <?php echo ($selected_category === $category) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(ucfirst($category)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button type="submit">Применить фильтр</button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Быстрые фильтры (ссылки с предустановленными параметрами) -->
    <div class="quick-filters">
        <strong>Быстрые фильтры:</strong>
        <a href="?min_price=1000">Товары дороже 1000 руб.</a>
        <a href="?min_price=5000">Товары дороже 5000 руб.</a>
        <a href="?category=книги">Только книги</a>
        <a href="?category=электроника">Только электроника</a>
        <a href="?min_price=2000&max_price=10000">Товары от 2000 до 10000 руб.</a>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Сбросить фильтры</a>
    </div>
    
    <!-- Результаты фильтрации -->
    <h3>Результаты: <?php echo count($filtered_products); ?> товаров</h3>
    
    <?php if (count($filtered_products) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Название товара</th>
                    <th>Категория</th>
                    <th>Цена (руб.)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filtered_products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($product['category'])); ?></td>
                        <td class="price"><?php echo number_format($product['price'], 0, '', ' '); ?> руб.</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Товары не найдены. Попробуйте изменить параметры фильтрации.</p>
    <?php endif; ?>
    
    
    <?php if (isset($_GET) && !empty($_GET)): ?>
      
    <?php endif; ?>
</body>
</html>