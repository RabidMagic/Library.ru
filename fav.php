<?php
include_once 'FavBook.php';
$fav = new FavBook($_SESSION['login']);
$fav->showFav($mdb2, 'upload_books', 'id');
?>