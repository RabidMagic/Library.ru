<?php 
require_once 'connect.php';
require_once 'func.php';
require_once 'classes/OutputSelect.php';
session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Личный кабинет</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/account.css">
        <script type="text/javascript" src="javascript/account_script.js"></script>
    </head>
    <body>
        <div id="popup-info" style="display: none;">
            <?php
            if ($_SESSION['us_group'] == 'admin') {
            include_once 'adminpanel.php';
            }
            if ($_SESSION['us_group'] == 'admin' || $_SESSION['us_group'] == 'moder') {
            include_once 'addbook.php';
            }
            ?>
        </div>
        <section id="container">
            <a href="catalog.php"><img id="tocatalog" src="img/tocatalog.png" alt="catalog"></a>
            <img id="coffee" src="img/account_coffee.png" alt="coffee">
            <div id="toindex"><a href="index.php"><img src="img/tomain.png" alt="main"></a></div>
            <article id="main">
                <h2>Избранные книги</h2>
                <?php
                require_once 'fav.php'; 
                ?>
            </article>
            <img id="addbook" src="img/account_feather.png" alt="feather">
            <a href="guestbook.php"><img id="toguest" src="img/toguest.png" alt="gueast"></a>
        </section>
    </body>
</html>
