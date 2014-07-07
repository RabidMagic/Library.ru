<?php
include_once 'classes/FavBook.php';
session_start();
$ref = $_SERVER['HTTP_REFERER'];
$options = array ('id'=>$_POST['id'],
        'title'=>$_POST['title'],
        'img'=>$_POST['img'],
        'author'=>$_POST['author']
        );
$fav_add = new FavBook($_SESSION['login'], $options);
$fav_add->addFav();
if (!$fav_add->stat) { $_SESSION['messages'] = '<p>Не удалось добавить книгу в Избранное</p>'; }
header('Location: '.$ref);