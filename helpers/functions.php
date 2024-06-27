<?php


/**
 * @return array|mixed
 */
function getUsersList(): mixed
{
    $usersData = file_get_contents('users.json');
    $usersArray = json_decode($usersData, true);
    return $usersArray['users'] ?? [];
}

/**
 * @param $login
 * @return bool
 */
function existsUser($login): bool
{
    $users = getUsersList();
    return array_key_exists($login, $users);
}

/**
 * @param $login
 * @param $password
 * @return bool
 */
function checkPassword($login, $password): bool
{
    $users = getUsersList();
    if (existsUser($login)) {
        return password_verify($password, $users[$login]['password']);
    }
    return false;
}

/**
 * @return mixed
 */
function getCurrentUser(): mixed
{
    return $_SESSION['user'] ?? null;
}

/**
 * @param $login
 * @return mixed
 */
function getUserData($login): mixed
{
    $users = getUsersList();
    return $users[$login] ?? null;
}

/**
 * @param $startTime
 * @param $durationInSeconds
 * @return string
 */
function calculateTimeLeft($startTime, $durationInSeconds): string
{
    $currentTime = time();
    $endTime = $startTime + $durationInSeconds;
    $timeLeft = $endTime - $currentTime;

    if ($timeLeft > 0) {
        $hours = floor($timeLeft / 3600);
        $minutes = floor(($timeLeft % 3600) / 60);
        $seconds = $timeLeft % 60;
        return "$hours часов $minutes минут $seconds секунд";
    }
    return "Скидка истекла.";
}

/**
 * @param $birthdate
 * @return bool|int
 * @throws Exception
 */
function calculateDaysUntilBirthday($birthdate): bool|int
{
    $currentDate = new DateTime();
    $birthday = new DateTime($birthdate);
    $birthday->setDate($currentDate->format('Y'), $birthday->format('m'), $birthday->format('d'));

    if ($birthday < $currentDate) {
        $birthday->modify('+1 year');
    }

    return $currentDate->diff($birthday)->days;
}

/**
 * @param $birthdate
 * @return bool
 * @throws Exception
 */
function isBirthdayToday($birthdate): bool
{
    $currentDate = new DateTime();
    $birthday = new DateTime($birthdate);
    return $currentDate->format('m-d') == $birthday->format('m-d');
}
