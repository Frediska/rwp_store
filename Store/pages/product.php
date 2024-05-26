<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../css/style.css">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Описание товара</title>
</head>
<body>
    <a href="../index.php" class="select"><- Вернуться на главную</a>
    <header>
        <div class="title_text">
            <h1>
                Описание товара
            </h1>
        </div>
    </header>
    <?php
    $productId = $_GET['id'];

    $db_host = '127.0.0.1:3306';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'cosmetic_store';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $query = "SELECT p.id, p.name, c.name AS category, p.price, p.weight, p.quantity, 
    p.description, p.image, p.storage_life
    FROM Product p
    JOIN ProductCategory c ON p.category = c.id
    WHERE p.id = '$productId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>{$row['name']}</h2>";
        echo "<img src='../images/{$row['image']}' width='500' height='500'>";
        echo "<p><strong>Категория: </strong>{$row['category']}</p>";
        echo "<p><strong>Цена: </strong>{$row['price']} RUB</p>";
        echo "<p><strong>Вес: </strong>{$row['weight']} гр.</p>";
        echo "<p><strong>Количество: </strong>{$row['quantity']} шт.</p>";
        echo "<p><strong>Описание: </strong>{$row['description']}</p>";
        echo "<p><strong>Срок хранения: </strong> до {$row['storage_life']}</p>";
    } else {
        echo "Товар не найден.";
    }
    ?>
    <form method="POST" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
        <button type="submit" id=registr_button>Добавить в корзину</button>
    </form>
</body>
</html>