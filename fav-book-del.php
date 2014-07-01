<?php
include_once 'FavBook.php';
session_start();
$ref = $_SERVER['HTTP_REFERER'];
$options = array ('id'=>$_POST['id']);
$fav_del = new FavBook($_SESSION['login'], $options);
$fav_del->delFav();
if ($fav_del->getStat() == FALSE) $_SESSION['messages'] = '<p>Не удалось удалить книгу в Избранное</p>';
header('Location: '.$ref);
?>