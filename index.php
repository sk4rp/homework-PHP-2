<?php
session_start();
require 'helpers/functions.php';

$user = getCurrentUser();
$personalDiscountDuration = 24 * 3600; // 24 часа
$loginTime = $_SESSION['login_time'] ?? time();

if ($user) {
    $userData = getUserData($user);
    $timeLeft = calculateTimeLeft($loginTime, $personalDiscountDuration);
    $daysUntilBirthday = calculateDaysUntilBirthday($userData['birthdate']);
    $isBirthday = isBirthdayToday($userData['birthdate']);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header, section {
            margin: 20px 0;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<header>
    <h1>SPA-салон "Relax"</h1>
    <?php if ($user): ?>
        <p>Вы вошли как: <?php echo htmlspecialchars($user); ?></p>
        <p><a href="auth/logout.php">Выйти</a></p>
        <h2>Персональная скидка</h2>
        <p>До истечения персональной скидки осталось: <?php echo $timeLeft; ?></p>
        <?php if ($isBirthday): ?>
            <p>С Днём Рождения! У вас персональная скидка 5% на все услуги!</p>
        <?php else: ?>
            <p>До вашего дня рождения осталось: <?php echo $daysUntilBirthday; ?> дней</p>
        <?php endif; ?>
    <?php else: ?>
        <p><a href="auth/login.php">Войти</a> или <a href="auth/register.php">Зарегистрироваться</a></p>
    <?php endif; ?>
</header>

<section>
    <h2>Наши услуги</h2>
    <ul>
        <li>Массаж</li>
        <li>Уход за лицом</li>
        <li>СПА-процедуры</li>
        <li>Маникюр и педикюр</li>
    </ul>
</section>

<section>
    <h2>Акции</h2>
    <ul>
        <li>Скидка 20% на первый визит</li>
        <li>Каждую пятницу скидка 15% на все услуги</li>
    </ul>
</section>

<section>
    <h2>Фото салона</h2>
    <img src="images/spa1.jpg" alt="Фото салона 1">
    <img src="images/spa2.jpg" alt="Фото салона 2">
</section>
</body>
</html>
