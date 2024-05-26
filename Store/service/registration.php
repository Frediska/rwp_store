<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $new_email = $_POST['new_email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $birthdate = $_POST['birthdate'];

    $uploadDirectory = '../Avatars/';

    $db_host = '127.0.0.1:3306';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'cosmetic_store';

    if ($new_password == $confirm_password) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    } else {
        die("Подтверждение пароля не совпадает. <a href=../pages/registration_form.php>Назад</a>");
    }

    if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['avatar']['tmp_name'];
        $newFilePath = $uploadDirectory . $_FILES['avatar']['name'];

        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $avatar_path = $newFilePath;
        } else {
            die("Ошибка при загрузке аватара. <a href=../pages/registration_form.php>Назад</a>");
        }
    } else {
        die("Ошибка при загрузке файла. <a href=../pages/registration_form.php>Назад</a>");
    }

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $new_email = $conn->real_escape_string($new_email);

    $check_query = "SELECT id FROM Users WHERE email = '$new_email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo 'Пользователь с такой электронной почтой уже зарегистрирован.';
    } else {
        $insert_query = "INSERT INTO Users (FIO, email, avatar, phone, address, password, birthdate)
        VALUES ('$last_name $first_name $middle_name', '$new_email', '$avatar_path', '$phone',
        '$address', '$new_password', '$birthdate')";

        $insert_result = $conn->query($insert_query);
    }
    
    if ($insert_result) {
        echo 'Регистрация успешна. Теперь вы можете <a href="../pages/log.php">войти</a>.';
    } else {
        echo 'Ошибка регистрации. Попробуйте еще раз. <a href=../pages/log.php>Вернуться к авторизации</a>';
    }

    $conn->close();
}
?>