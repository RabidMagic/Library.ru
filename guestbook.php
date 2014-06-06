<?php
require_once 'func.php';
require_once 'connect.php';
require_once 'PageButtons.php';
require_once 'GetResults.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека | Оставить отзыв</title>
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
                <div class="gb-output">
                    <?php
                    $num = 6; //<--- для смены кол-ва выводимых комментариев изменять это
                    $query = "SELECT * FROM review ORDER BY id DESC";
                    $get_review = new GetResults($num, $query, $mdb2);
                    $get_review->getReview();
                    $query = "SELECT * FROM review";
                    $get_gb_pb = new PageButtons($num, $query, $mdb2);
                    $get_gb_pb->getGBPageButtons();
                    ?>
                </div>
                <div class="gb-input">
                    <?php
                    if (!empty($messages))
                    {
                        displayErr($messages);
                    }
                    ?>
                    <form action="" method="post">
                        <?php (isset($_SESSION['login']) ? print "Ваше имя: <b>".$_SESSION['login']."</b>" : print "Ваше имя: <input type='text' name='login'>") ?>
                        <textarea class="gb-input-textarea" name="review"></textarea>
                        <input class="gb-buttons" type="reset" value="Сбросить">
                        <input class="gb-buttons" type="submit" name="submit" value="Отправить отзыв">
                    </form>";
                </div>             
            </article>
            <?php require_once 'footer.php'; ?>
        </section>
    </body>
</html>
