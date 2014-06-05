<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
$_POST['login'] = securityCheck($_POST['login']);
$_POST['password'] = securityCheck($_POST['password']);
field_validator("'Логин'", $_POST['login'], "alphanumeric", 4, 32);
field_validator("'Пароль'", $_POST['password'], "string", 4, 16);
if (checkUser($_POST['login'], $_POST['password']) === TRUE)
{
    $messages[] = "Такого пользователя не существует";
} else $fetch = checkUser($_POST['login'], $_POST['password']);
$referer = $_SERVER['HTTP_REFERER'];
if (isset($messages)) $_SESSION['messages'] = $messages;
if (empty($messages))
{
    if (!setSession($fetch['login'], $fetch['password'], $fetch['us_group']))
    {
        $messages[] = "Ошибка при подключении";
        $_SESSION['messages'] = $messages;
        header("Location: auth.php");
    } else {
        if (!empty($_SESSION['referer'])) $referer = $_SESSION['referer'];
        unset($_SESSION['referer']);
        unset($_SESSION['count']);
        if ($referer == NULL) { $referer = 'index.php'; }
        header("Location: $referer");
    }
} else header ("Location: auth.php");
