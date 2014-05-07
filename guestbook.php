<?php
//Пока не доделано
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['submit']))
{
    //$messages = array();
    if (empty($_POST['review']))
    {
        $messages[] = "Вы не ввели отзыв";
    }
    if (empty($_SESSION['login']) && empty($_POST['name']))
    {
        $messages[] = "Вы не указали имя";
    }
    if (isset($_POST['name']))
    {
        $name = $_POST['name'];
    } else $name = $_SESSION['login'];
    if (empty($messages))
    {
        $review = $_POST['review'];
        $review = mysql_real_escape_string($review);
        $review = htmlspecialchars($review);
        $name = mysql_real_escape_string($name);
        $name = htmlspecialchars($name);
        $date = date("d-m-Y");
        if (inputReview($name, $date, $review) == TRUE)
        {
            $messages[] = "Отзыв был успешно добавлен";
            header("Location: guestbook.php");
        }
    }
}
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
                    <?php
                    getReview(10);
                    getPageButtons(review,10);
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
                        <?php (isset($_SESSION['login']) ? print "Ваше имя: ".$_SESSION['login'] : print "Ваше имя: <input type='text' name='name'>") ?>
                        <textarea class="gb-input-size" name="review" id="gb-review"></textarea>
                        <input class="gb-buttons" type="reset" value="Сбросить">
                        <input class="gb-buttons" type="submit" name="submit" value="Отправить отзыв">
                    </form>";
                </div>             
            </article>
            <?php include_once 'footer.php'; ?>
        </section>
    </body>
</html>
