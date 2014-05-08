<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
$page_id = $_POST['page_id'];
$book_id = $_POST['book_id'];
$login = $_SESSION['login'];
$query = "SELECT * FROM favourites WHERE book_id=$book_id";
$result = mysql_query($query, $link);
if (mysql_num_rows($result) == 0)
{
    $query = "INSERT INTO favourites (login,book_id) VALUES ('$login', '$book_id')";
    $result = mysql_query($query, $link);
}
header("Location: page.php?id=$page_id");
?>
