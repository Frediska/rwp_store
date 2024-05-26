<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['Password'];

    $db_host = '127.0.0.1:3306';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'cosmetic_store';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $email = $conn->real_escape_string($email);

    $query = "SELECT id, email, password FROM Users WHERE email ='$email'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            
            $conn->close();
            
            header('Location: ../pages/log.php');
            exit();
        } else {
            echo 'Ошибка входа. Проверьте логин и пароль.<br>';
            echo '<a href="../pages/log.php">Назад</a>';
        }
    } else {
        echo 'Ошибка входа. Проверьте логин и пароль.<br>';
        echo '<a href="../pages/log.php">Назад</a>';
    }

    $conn->close();
}
?>