<?php
include_once 'FavBook.php';
session_start();
$ref = $_SERVER['HTTP_REFERER'];
$options = array ('id'=>$_POST['id']);
$fav_del = new FavBook('del', $options);
if ($fav_del->getStat() == FALSE) $_SESSION['messages'] = '<p>Не удалось удалить книгу в Избранное</p>';
header('Location: '.$ref);
?>