<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="../Image/logo.ico">
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
    </head>
    <body>
        <section id="temp">
            <a href="index.php">Главная</a><br>
            <?php
            if (isset($_POST['exit']))
            {
                unset($_SESSION['login']);
                unset($_SESSION['id']);
                echo "Вы успешно вышли из профиля";
            }
            ?>
        </section>
    </body>
</html>
