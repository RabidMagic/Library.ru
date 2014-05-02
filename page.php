<?php 
session_start(); 
include_once 'func.php';
include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека | Каталог</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <?php include 'header.php'; ?>
            <?php include 'nav.php'; ?>
            <article id="main">
                <?php
                $id = $_GET['id'];
                $id = mysql_real_escape_string($id);
                $result = mysql_query("SELECT * FROM upload_books WHERE id = '$id'");
                $fetch = mysql_fetch_array($result);
                if (mysql_num_rows($result) === 1)
                {
                    print "<img src='uploads/".$fetch['img']."' alt='картинка'>
                    <div>
                        <h1>".$fetch['book_name']."</h1>
                        <h3>".$fetch['author']."</h3>
                        <p>".$fetch['description']."</p>
                    </div>
                    <div class='user-date-page'><p>Добавил: <b>".$fetch['login']."</b> Дата: <b>".$fetch['date']."</b></p></div>
                    <div class='clearfix'></div>";
                } else print "Искомой книги найдено не было";
                ?>
            </article>
            <?php include 'footer.php'; ?>
        </section>
    </body>
</html>
