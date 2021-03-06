<?php
require_once 'func.php';
require_once 'connect.php';
require_once 'classes/GetResults.php';
require_once 'classes/PageButtons.php';
session_start();
$search = $_GET['search'];
$search = securityCheck($search);
if ($search == NULL) header ("Location: ".$_SERVER['HTTP_REFERER']);
$query = "SELECT author,description,book_name,id,genre FROM upload_books WHERE author LIKE '%$search%' || description LIKE '%$search%' || book_name LIKE '%$search%' || genre LIKE '%$search%'";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Библиотека | Результаты поиска</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <script type="text/javascript" src="javascript/main_scripts.js"></script>
        <style>
            h2 { text-align: center; }
        </style>
    </head>
    <body onload="pageLoaded();">
        <section id="container">
            <?php require_once 'header.php'; ?>
            <article id="main">
                <?php
                $search = stripslashes($search);
                print "<h2>По Вашему запросу '$search' было найдено совпадений: ". $mdb2->query($query)->numRows()."</h2>";
                $num = 3; //<--- для смены кол-ва выводимых комментариев изменять это
                $get_search = new GetResults($num, $query, $mdb2);
                $get_search->getSearchResults();
                $inset = array('search'=>$_GET['search']);
                $search_pb = new PageButtons($num, $query, $mdb2, $inset);
                $search_pb->getButtons();
                ?>
            </article>
            <?php require_once 'footer.php'; ?>
        </section>
    </body>
</html>
