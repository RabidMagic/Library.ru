<?php
require_once 'func.php';
require_once 'connect.php';
if (isset($_POST['submit']))
{
    if (empty($_POST['review']))
    {
        $messages[] = "Вы не ввели отзыв";
    }
    if (empty($_SESSION['login']) && empty($_POST['login']))
    {
        $messages[] = "Не указан логин";
    } else if (isset($_POST['login']))
    {
        $_POST['login'] = securityCheck($_POST['login']);
        if (checkName($_POST['login']) == TRUE)
        {
            field_validator("'Логин'", $_POST["login"], "alphanumeric", 4, 32);
            $name = $_POST['login'];
        } else $messages[] = "Такой логин уже есть";
    } else $name = $_SESSION['login'];
    if (empty($messages))
    {
        $review = $_POST['review'];
        $review = securityCheck($review);
        $query = "INSERT INTO review (login, content) VALUES ('$name', '$review')";
        if (Input($query) == TRUE)
        {
            $_SESSION['messages'] = $messages;
            header("Location: guestbook.php");
        } else $messages[] = "Ошибка! Невозможно добавить в БД";
    }
    $_SESSION['messages'] = $messages;
}
