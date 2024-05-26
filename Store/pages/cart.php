<?php
function addToCart($productId) {
    $cartData = loadCartData();
    $productExists = false;

    foreach ($cartData as &$cartItem) {
        if ($cartItem["id"] == $productId) {
            $cartItem["quantity"]++;
            $productExists = true;
            break;
        }
    }

    if (!$productExists) {
        $productData = getProductData($productId);
        if ($productData) {
            $productData["quantity"] = 1;
            $cartData[] = $productData;
        }
    }

    saveCartData($cartData);
    header("Location: cart.php");
}

function removeFromCart($productId) {
    $cartData = loadCartData();

    foreach ($cartData as $key => $cartItem) {
        if ($cartItem["id"] == $productId) {
            unset($cartData[$key]);
            break;
        }
    }

    saveCartData(array_values($cartData));
    header("Location: cart.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    addToCart($_POST["product_id"]);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    removeFromCart($_GET["id"]);
} else {
    displayCart();
}

function loadCartData() {
    return json_decode(file_get_contents("../cart.txt"), true);
}

function saveCartData($cartData) {
    file_put_contents("../cart.txt", json_encode($cartData));
}

function getProductData($productId) {
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

        return $row;
    }
    return null;
}

function displayCart() {
    $cartData = loadCartData();
    if ($cartData) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <link rel=stylesheet href=../css/style.css>
            <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
            <title>Корзина</title>
        </head>
        <body>
            <a href=../index.php class=select><- Вернуться на главную</a>
            <header>
                <div class=title_text>
                    <h1>
                        Корзина
                    </h1>
                </div>
            </header>
            <table>
                <tr>
                    <th>Картинка товара</th>
                    <th>Название товара</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Удалить</th>
                </tr>";
        $totalPrice = 0;
        foreach ($cartData as $cartItem) {
            $totalPrice += $cartItem["price"] * $cartItem["quantity"];
            echo "<tr>";
            echo "<td><img src='../images/{$cartItem['image']}' width='100' height='100'></td>";
            echo "<td>{$cartItem['name']}</td>";
            echo "<td>";
            echo "<button class='quantity-button' data-product-id='{$cartItem['id']}' onclick='decrementQuantity({$cartItem['id']})'>-</button>";
            echo "<span id='quantity-{$cartItem['id']}'>{$cartItem['quantity']}</span>";
            echo "<button class='quantity-button' data-product-id='{$cartItem['id']}' onclick='incrementQuantity({$cartItem['id']})'>+</button>";
            
            echo "</td>";
            echo "<td>{$cartItem['price']} RUB</td>";
            echo "<td><a href='?id={$cartItem['id']}'><img src='../icons/delete_img.png' width='50' height='50'></a></td>";
            echo "</tr>";
        }
        echo "</table><p>Общая сумма: $totalPrice RUB</p>";
        echo "</body></html>";
        echo "<script>
            function incrementQuantity(productId) {
                var quantityElement = document.getElementById('quantity-' + productId);
                var currentQuantity = parseInt(quantityElement.textContent);
                quantityElement.textContent = currentQuantity + 1;
                updateCart();
            }

            function decrementQuantity(productId) {
                var quantityElement = document.getElementById('quantity-' + productId);
                var currentQuantity = parseInt(quantityElement.textContent);
                if (currentQuantity > 1) {
                    quantityElement.textContent = currentQuantity - 1;
                    updateCart();
                }
            }

            function updateCart() {
                var cartData = [];
                document.querySelectorAll('.quantity-button').forEach(function (element) {
                    var productId = element.getAttribute('data-product-id');
                    var quantityElement = document.querySelector('#quantity-' + productId);
                    var quantity = quantityElement ? parseInt(quantityElement.textContent) : 0;
                    cartData.push({ id: productId, newQuantity: quantity });
                });
            
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../service/update_cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            if (xhr.responseText === 'success') {
                                location.reload();
                            } else {
                                alert('Произошла ошибка при обновлении корзины.');
                            }
                        }
                    }
                };
            
                xhr.send('cartData=' + JSON.stringify(cartData));
            }
        </script>";
    } else {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <link rel=stylesheet href=../css/style.css>
            <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
            <title>Корзина</title>
        </head>
        <body>
            <a href=../index.php class=select><- Вернуться на главную</a>
            <header>
                <div class=title_text>
                    <h1>
                        Корзина
                    </h1>
                    <h3>Корзина пуста.</h3>
                </div>
            </header>
        </body>
        </html>";
    }
}
?>