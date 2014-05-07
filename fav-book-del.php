<?php
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['fav-del']))
{
    $query_fav = "DELETE FROM favourites WHERE login='".$_POST['fav-login']."' && book_id='".$_POST['fav-b-id']."'";
    $result_fav = mysql_query($query_fav, $link);
    header("Location: account.php");
}
?>