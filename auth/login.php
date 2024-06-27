<?php
session_start();
require '../helpers/functions.php';

if (getCurrentUser()) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkPassword($login, $password)) {
        $_SESSION['user'] = $login;
        $_SESSION['login_time'] = time();
        header('Location: index.php');
        exit();
    }

    $error = 'Неверный логин или пароль';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
<h1>Вход</h1>
<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST">
    <label for="login">Логин:</label>
    <input type="text" id="login" name="login" required>
    <br>
    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Войти</button>
</form>
</body>
</html>
