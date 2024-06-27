<?php
require '../helpers/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';

    if (existsUser($login)) {
        $error = 'Пользователь с таким логином уже существует.';
    } else {
        $users = getUsersList();
        $users[$login] = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'birthdate' => $birthdate
        ];
        file_put_contents('users.json', json_encode(['users' => $users], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
<h1>Регистрация</h1>
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
    <label for="birthdate">Дата рождения:</label>
    <input type="date" id="birthdate" name="birthdate" required>
    <br>
    <button type="submit">Зарегистрироваться</button>
</form>
</body>
</html>
