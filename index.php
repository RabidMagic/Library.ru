<?php 
require_once 'func.php';
require_once 'connect.php';
require_once 'ShowNews.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <script type="text/javascript" src="javascript/main_scripts.js"></script>
    </head>
    <body onload="pageLoaded();">
        <?php        
            include_once 'login_pop-up.php'; 
            include_once 'reg_pop-up.php';             
        ?>
        <section id="container">
            <?php
            require_once 'header.php';
            ?>
            <article id="main">
                <div id="about">
                    <h1>О нас</h1>
                    <p>Что-то бесполезное</p>
                </div>
                <div id="newblebox">
                    <h1>Обновления</h1>
                    <?php
                    $query = "SELECT * FROM upload_books ORDER BY id DESC";
                    $show_books = new ShowNews($query, $mdb2);
                    $show_books->ShowBooks();
                    ?>
                </div>
                <div id="newsbox">
                    <?php
                    $query = "SELECT * FROM news ORDER BY id DESC";
                    $show_news = new ShowNews($query, $mdb2);
                    $show_news->ShowNews();
                    ?>
                </div>
            </article>
            <?php require_once 'footer.php'; ?>
            <div class="clearfix"></div>
        </section>  
    </body>
</html>
