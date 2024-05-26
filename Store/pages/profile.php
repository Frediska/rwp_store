<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../css/style.css">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Личный кабинет</title>
</head>
<body>
    <header>
        <div class="title_text">
            <h1>
                Личный кабинет
            </h1>
        </div>
    </header>
    <div class="content">
        <div class="header_menu">
            <a href="../index.php" class="select">Главная</a>
            <a href="log.php" class="select">Войти в аккаунт</a>
            <a href="profile.php" class="select">Личный кабинет</a>
            <a href="cart.php" class="select">Корзина</a>
        </div>
        <div class="tabs_profile">
            <div class="tab" id="personalTab">Личные данные</div>
            <div class="tab" id="orderHistoryTab">История заказов</div>
        </div>
        <div class="profile" id="personalContent">
            <?php 
            session_start();

            $db_host = '127.0.0.1:3306';
            $db_user = 'root';
            $db_password = '';
            $db_name = 'cosmetic_store';

            $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            $user_id = $_SESSION['user_id'];

            if (isset($user_id)) {
                $query = "SELECT FIO, email, avatar, phone, address, birthdate FROM Users
                WHERE id = '$user_id'";
                $result = $conn->query($query);

                $row = $result->fetch_assoc();

                echo "<div class=title_text><h2>Личные данные</h2></div>";
                echo "ФИО: " . $row['FIO'] . "<br>";
                echo "Почта: " . $row['email'] . "<br>";
                echo "Номер телефона: " . $row['phone'] . "<br>";
                echo "Адрес доставки: " . $row['address'] . "<br>";
                echo "Дата рождения: " . $row['birthdate'] . "<br>";
                echo "<p><strong>Аватар пользователя :</strong></p><img src='" . 
                $row['avatar'] . "'width='450' height='500'>";
            } else {
                echo "Войдите в аккаунт для просмотра личного кабинета.";
            }
            $conn->close();
            ?>
        </div>
        </div>
        <div class="profile" id="orderHistoryContent">
            <?php
            session_start();

            $db_host = '127.0.0.1:3306';
            $db_user = 'root';
            $db_password = '';
            $db_name = 'cosmetic_store';

            $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            if (isset($user_id)) {
                $query = "SELECT p.name AS PName, op.count, s.name AS SName, s.address, p.image
                FROM UserOrder o
                JOIN UserOrderProduct op ON op.orderId = o.id
                JOIN Store s ON s.id = o.store
                JOIN Product p ON p.id = op.productId
                WHERE o.customer = '$user_id'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    $data = [];
        
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }

                    echo "<div class=title_text><h2>Ваши заказы:</h2></div>";
                    echo "<table class='order_table'>
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Количество</th>
                            <th>Магазин</th>
                            <th>Адрес магазина</th>
                            <th>Изображение</th>
                        </tr>
                    </thead>";
                    foreach ($data as $row) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td>" . $row['PName'] . "</td>";
                        echo "<td>". $row['count'] . " шт.</td>";
                        echo "<td>" . $row['SName'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td><img src='../images/{$row['image']}' width='100' height='100'></td>";
                        echo "</tr>";
                        echo "</tbody>"; 
                    }
                    echo "</table>";
                } else {
                    echo "У вас нет истории заказов.";
                }             
            } else {
                echo "Войдите в аккаунт для просмотра истории заказов.";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script src="../script_profile.js"></script>
</body>
</html>