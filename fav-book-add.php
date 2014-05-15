<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
$query = "SELECT * FROM favourites WHERE book_id='".$_POST['book_id']."'";
$result = $mdb2->query($query);
if ($result->numRows() == 0)
{
    $query = "INSERT INTO favourites (login,book_id) VALUES ('".$_SESSION['login']."', '".$_POST['book_id']."')";
    $result = $mdb2->exec($query);
}
header("Location: page.php?id=".$_POST['book_id']);
?>
