<?php 
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
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
    </head>
    <body>
        <section id="container">
            <?php require 'header.php'; ?>
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
        </section>  
    </body>
</html>
