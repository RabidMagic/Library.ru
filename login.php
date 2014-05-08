<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
$_POST['login'] = htmlspecialchars($_POST['login']);
$_POST['password'] = htmlspecialchars($_POST['password']);
field_validator("'Логин'", $_POST['login'], "alphanumeric", 4, 32);
field_validator("'Пароль'", $_POST['password'], "string", 4, 16);
if (checkUser($_POST['login'], $_POST['password']) === TRUE)
{
    $messages[] = "Такого пользователя не существует";
}
$_SESSION['messages'] = $messages;
if (empty($messages))
{
    if (!reMemberSess($fetch['login'], $fetch['password']))
    {
        $messages[] = "Ошибка при подключении";
        $_SESSION['messages'] = $messages;
        header("Location: auth.php");
    } else header("Location: index.php");
} else    header ("Location: auth.php");
