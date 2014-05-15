<?php 
require_once 'func.php';
require_once 'connect.php';
session_start(); 
checkLogIn();
if (isset($_POST['logout']))
{
    if (flushSession())
    {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Личный кабинет</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <article id="main">
                <?php
                require_once 'addbook.php';
                ?>
                <form action="" method="post">
                    <input type="submit" value="Выйти" name="logout">
                </form>
                <a href='index.php'><button>Главная</button></a><br>
                <?php require_once 'fav.php'; ?>
            </article>
        </section>
        <?php require_once 'footer.php' ?> 
    </body>
</html>
