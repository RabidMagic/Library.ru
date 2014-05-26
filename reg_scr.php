<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
field_validator("'Логин'", $_POST["login"], "alphanumeric", 4, 32);
field_validator("'Пароль'", $_POST["password"], "string", 4, 16);
field_validator("'Подтверждение пароля'", $_POST["password2"], "string", 4, 16);
field_validator("e-mail", $_POST['email'], "email");
if (!checkName($_POST['login']))
{
    $messages[] = "Такой логин уже есть";
}
if (strcmp($_POST['password'], $_POST['password2']))
{
    $messages[] = "Ваши пароли не совпадают";
}
if (empty($_POST['gender']))
{
    $messages[] = "Вы не выбрали пол";
}
if (!empty($_POST['reg-b-month']) && !empty($_POST['reg-b-day']) && !empty($_POST['reg-b-year']))
{
    if (!checkdate($_POST['reg-b-month'], $_POST['reg-b-day'], $_POST['reg-b-year']))
    {
        $messages[] = "Введена некорректная дата";
    }
} else $messages[] = "Вы не ввели дату рождения";
if (!empty($_POST['email']))
{
    $result = $mdb2->query("SELECT email FROM users WHERE email = '".$_POST['email']."'");
    if ($result->numRows() != 0)
    {
        $messages[] = "Этот e-mail уже занят";
    }
} else $messages[] = "Вы не ввели e-mail";
if ($_POST['checkbot'] == 'yes')
{
    $messages[] = "Проверка показала, что вы робот :)";
}
if (empty($messages))
{
    $birthdate = array($_POST['reg-b-day'], $_POST['reg-b-month'], $_POST['reg-b-year']);
    $birthdate = implode("-", $birthdate);
    if (newUser($_POST['login'], $_POST['password'], $_POST['gender'], $birthdate, $_POST['email']) && setSession($_POST['login'], $_POST['password'], 'user'))
    {
        header("Location: index.php");
    } else $messages[] = "Не удалось зарегистрироваться и/или залогиниться";
} else {
    $_SESSION['messages'] = $messages;
    header("Location: registration.php");
}