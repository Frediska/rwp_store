<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cartData"])) {
    $cartData = json_decode($_POST["cartData"], true);

    $cartFile = '../cart.txt';
    $currentCartData = loadCartData($cartFile);

    foreach ($cartData as $updatedItem) {
        $productId = $updatedItem["id"];
        $newQuantity = $updatedItem["newQuantity"];

        foreach ($currentCartData as &$cartItem) {
            if ($cartItem["id"] == $productId) {
                $cartItem["quantity"] = $newQuantity;
                break;
            }
        }
    }

    saveCartData($currentCartData, $cartFile);

    echo "success";
} else {
    echo "Ошибка запроса";
}

function loadCartData($cartFile) {
    return json_decode(file_get_contents($cartFile), true);
}

function saveCartData($cartData, $cartFile) {
    file_put_contents($cartFile, json_encode($cartData));
}
?>
