<?php 
session_start();
include_once 'func.php';
include_once 'connect.php';
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
            <?php include 'header.php'; ?>
            <article id="main">
                <div id="about">
                    <h1>О нас</h1>
                    <p>Некая бесполезная информация о разработчиках сайта.</p>
                </div>
                
                <div id="newblebox">
                    <h1>Обновление</h1>
                    <?php
                        showNews();
                    ?>
                </div>
                
                <div id="newsbox">
                    <h1></h1>
                    <p></p>
                </div>
            </article>
            <?php include 'footer.php'; ?>
        </section>  
    </body>
</html>
