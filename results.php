<?php
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
session_start();
$search = $_GET['search'];
$search = securityCheck($search);
if ($search == NULL) header ("Location: ".$_SERVER['HTTP_REFERER']);
$query = "SELECT author,description,book_name FROM upload_books WHERE author LIKE '%$search%' || description LIKE '%$search%' || book_name LIKE '%$search%'";
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
            <?php require_once 'header.php'; ?>
            <article id="main">
                <?php
                print "По Вашему запросу было найдено совпадений: ".$mdb2->query($query)->numRows();
                $num = 3; //<--- для смены кол-ва выводимых комментариев изменять это
                $get_search = new GetResults($num, $query, $mdb2);
                $get_search->getSearchResults();
                $search_pb = new PageButtons($num, $query, $mdb2);
                $search_pb->getSearchPageButtons();
                ?>
            </article>
            <?php require_once 'footer.php'; ?>
        </section>
    </body>
</html>
