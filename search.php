<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
$search = $_POST['search'];
$search = securityCheck($search);
$query = "SELECT author,description,id,book_name FROM upload_books WHERE author LIKE '%$search%' || description LIKE '%$search%' || book_name LIKE '%$search%'";
$result = mysql_query($query, $link);
if (mysql_num_rows($result) > 0)
{
    $fetch = mysql_fetch_array($result);
    $_SESSION['result'] = $fetch;
}
?>

