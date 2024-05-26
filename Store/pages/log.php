<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../css/style.css">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Вход в аккаунт</title>
</head>
<body>
    <a href="../index.php" class="select"><- Вернуться на главную</a>
    <header>
        <div class="title_text">
            <h1>
                Вход
            </h1>
        </div>
    </header>
    <div class="registr">
    <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo "<p>Вы вошли в свой аккаунт! <br> Добро пожаловать, " . $_SESSION['email'] . "!<br>
            <a href=logout.php>Выход</a>";
        } else {
            echo '<form action="../service/login.php" method="post">
                    Электронная почта: <input type="text" name="email" required>
                    <p>Пароль: <input type="password" name="Password" required><br>
                    <br><button type="submit" id=registr_button>Вход</button>
                    <a href="registration_form.php" class="select">Зарегистрироваться</a>
                </form>';
        }
    ?>
    </div>
</body>
</html>
