<?php
include_once 'func.php';
include_once 'connect.php';
$query_fav = "DELETE FROM favourites WHERE login='".$_POST['fav-login']."' && book_id='".$_POST['fav-b-id']."'";
$result_fav = mysql_query($query_fav, $link);
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
?>