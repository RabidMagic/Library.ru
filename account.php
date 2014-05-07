<?php 
session_start(); 
include_once 'func.php';
include_once 'connect.php';
checkLogIn();
if (isset($_POST['logout']))
{
    if (clearSess())
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
                include_once 'addbook.php';
                ?>
                <form action="" method="post">
                    <input type="submit" name="logout" value="Выйти">
                </form>
                <a href='index.php'>Главная</a><br>
            </article>
        </section>
        <?php include 'footer.php' ?> 
    </body>
</html>
