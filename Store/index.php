<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="css/style.css">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Интернет-магазин</title>
</head>
<body>
    <header>
        <div class="title_text">
            <h1>
                Интернет-магазин косметики
            </h1>
        </div>
    </header>
    <div class="content">
        <div class="header_menu">
            <a href="pages/log.php" class="select">Войти в аккаунт</a>
            <a href="pages/profile.php" class="select">Личный кабинет</a>
            <a href="pages/cart.php" class="select">Корзина</a>
        </div>
        <button id="tableButton">Таблица</button>
        <button id="columnButton">Столбик</button>
        <?php

        $db_host = '127.0.0.1:3306';
        $db_user = 'root';
        $db_password = '';
        $db_name = 'cosmetic_store';

        $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        
        $query = "SELECT p.id, p.name, c.name AS category, p.price, p.description, p.image 
        FROM Product p
        JOIN ProductCategory c ON p.category = c.id
        ORDER BY p.id";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo "<table class='products_table'>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Категория товара</th>
                    <th>Описание</th>
                    <th>Изображение</th>
                </tr>
            </thead>";
            foreach ($data as $row) {
                echo "<tbody>";
                echo "<tr>";
                echo "<td><a href='pages/product.php?id={$row['id']}'>" . 
                $row['name'] . "</a></td>";
                echo "<td>" . $row['price'] . " RUB</td>";
                echo "<td>". $row['category'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td><img src='images/{$row['image']}' width='300' height='300'></td>";
                echo "</tr>";
                echo "</tbody>"; 
            }
            echo "</table>";

            echo "<div class='product'>";
            foreach ($data as $row) {
                echo "<h3><a href='pages/product.php?id={$row['id']}'>" . $row['name'] . "</a></h3>";
                echo "<p><strong>Цена: </strong>" . $row['price'] . " RUB</p>";
                echo "<p><strong>Категория товара: </strong>". $row["category"] . "</p>";
                echo "<p><strong>Описание: </strong>" . $row['description'] . "</p>";
                echo "<p><strong>Изображение :</strong></p>";
                echo "<p><img src='images/{$row['image']}'></p>";
            }
            echo "</div>";
        }

        $conn->close();
        ?>
    </div>
    <script>
        const tableButton = document.getElementById('tableButton');
        const columnButton = document.getElementById('columnButton');
        const table = document.querySelector('.products_table');
        const column = document.querySelector('.product');
        
        tableButton.addEventListener('click', () => {
            table.style.display = 'table';
            column.style.display = 'none';
        });
        
        columnButton.addEventListener('click', () => {
            table.style.display = 'none';
            column.style.display = 'block';
        });

        tableButton.click();
    </script>
</body>
</html>