<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
if (empty($_SESSION['login']))
{
    $messages[] = "Не указан логин";
} else $login = $_SESSION['login'];
if (empty($_POST['page-content']))
{
    $messages[] = "Поле отзыва не должно быть пустым";
}
if (empty($messages))
{
    $content = $_POST['page-content'];
    $content = securityCheck($content);
    $login = securityCheck($login);
    $query = "INSERT INTO book_comments (login, content, book_id) VALUES ('$login', '$content', '".$_POST['page-b-id']."')";
    if (Input($query) == TRUE)
    {
        header("Location: page.php?id=".$_POST['page-b-id']);
    } 
}
