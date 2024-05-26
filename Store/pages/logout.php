<?php
    session_start();
    session_destroy();
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('email', '', time() - 3600, '/');
    header('Location: log.php');
    exit();
?>