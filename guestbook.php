<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека | Оставить отзыв</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <?php include_once 'header.php'; ?>
            <article id="main">
                <div class="gb-output">
                    <!--Вывод отзывов из базы, кнопки для пролистывания -->
                </div>
                <div class="gb-input">
                    <form action="" method="post">
                        Ваше имя( или псевдоним): <?php if (isset($_SESSION['login'])) { echo $_SESSION['login']; } else echo '<input type="text" name="name">' ?>
                        <textarea name="review"></textarea>
                        <input class="gb-buttons" type="reset" value="Сбросить">
                        <input class="gb-buttons" type="submit" value="Отправить отзыв">
                    </form>
                </div>             
            </article>
            <?php include_once 'footer.php'; ?>
        </section>
    </body>
</html>
