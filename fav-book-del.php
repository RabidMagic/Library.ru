<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
$query_fav = "DELETE FROM favourites WHERE login='".$_POST['fav-login']."' && book_id='".$_POST['fav-b-id']."'";
$result_fav = $mdb2->exec($query_fav);
header("Location: ".$_SERVER['HTTP_REFERER']);
?>