<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../css/style.css">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Регистрация</title>
</head>
<body>
    <a href="../index.php" class="select"><- Вернуться на главную</a>
    <header>
        <div class="title_text">
            <h1>
                Регистрация
            </h1>
        </div>
    </header>
    <div class="registr">
        <form action="../service/registration.php" method="post" enctype="multipart/form-data">
            <label>Фамилия:</label>
            <input type="text" name="last_name" required><br><br>

            <label>Имя:</label>
            <input type="text" name="first_name" required><br><br>

            <label>Отчество:</label>
            <input type="text" name="middle_name" required><br><br>

            <label>Почта:</label>
            <input type="email" name="new_email" required><br><br>

            <label>Номер телефона:</label>
            <input type="phone" name="phone" required><br><br>

            <label>Адрес доставки:</label>
            <input type="address" name="address" required><br><br>

            <label>Пароль:</label>
            <input type="password" name="new_password" required><br><br>

            <label>Повторите пароль:</label>
            <input type="password" name="confirm_password" required><br><br>

            <label>Дата рождения:</label>
            <input type="date" name="birthdate" required><br><br>

            <label>Загрузите аватар:</label>
            <input type="file" name="avatar" accept="image/*"><br><br>

            <button type="submit" id=registr_button>Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>