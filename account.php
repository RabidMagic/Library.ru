<?php 
require_once 'connect.php';
require_once 'func.php';
require_once 'OutputSelect.php';
session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Личный кабинет</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/account.css">
        <script type="text/javascript" src="javascript/main_scripts.js"></script>
    </head>
    <body>
        <div id="popUp">
        <div id="adminPanel" class="accountPopup">
            <div onclick="accountPopDown();">X</div>
            <?php include_once 'adminpanel.php'; ?>
        </div>
        
        <div id="addbookPanel" class="accountPopup">
            <div onclick="accountPopDown();">X</div>
            <?php include_once 'addbook.php';?>
        </div>
        </div>    
        
        <section id="container">
            <a href="catalog.php"><img id="tocatalog" src="img/tocatalog.png" alt="catalog"></a>
            <?php 
            if ($_SESSION['us_group'] == 'admin') {
                echo '<img id="coffee" src="img/account_coffee.png" alt="coffee" onclick="popUp(\'adminPanel\');">';
            }
            ?>
            <div id="toindex"><a href="index.php"><img src="img/tomain.png" alt="main"></a></div>
            <article id="main">
                <h2>Избранные книги</h2>
                <?php
                require_once 'fav.php'; 
                ?>
            </article>
            <?php
            if ($_SESSION['us_group'] == 'admin' || $_SESSION['us_group'] == 'moder') {
                echo '<img id="addbook" src="img/account_feather.png" alt="feather" onclick="popUp(\'addbookPanel\');">';
            }
            ?>
            <a href="guestbook.php"><img id="toguest" src="img/toguest.png" alt="gueast"></a>
        </section>
    </body>
</html>
