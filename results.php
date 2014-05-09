<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
$search = $_POST['search'];
$search = securityCheck($search);
$query = "SELECT author,description,id,book_name FROM upload_books WHERE author LIKE '%$search%' || description LIKE '%$search%' || book_name LIKE '%$search%'";
$result = mysql_query($query, $link);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Библиотека | Результаты поиска</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <?php include_once 'header.php'; ?>
            <article id="main">
                <?php
                print "По Вашему запросу было найдено совпадений: ".mysql_num_rows($result);
                getSearchResults(7);
                getPageButtons(upload_books, 7, '');
                ?>
            </article>
            <?php include_once 'footer.php'; ?>
        </section>
    </body>
</html>
