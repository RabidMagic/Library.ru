<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['submit']))
{
    if (empty($_POST['review']))
    {
        $messages[] = "Вы не ввели отзыв";
    }
    if (empty($_SESSION['login']) && empty($_POST['login']))
    {
        $messages[] = "Не указан логин";
    } else if (isset($_POST['login']))
    {
        if (checkName($_POST['login']) == TRUE)
        {
            $name = $_POST['login'];
        } else $messages[] = "Такой логин уже есть";
    } else $name = $_SESSION['login'];
    if (empty($messages))
    {
        $review = $_POST['review'];
<<<<<<< HEAD
        $review = mysql_real_escape_string($review);
        $review = htmlspecialchars($review);
        $review = trim($review);
        $name = trim($name);
        $name = mysql_real_escape_string($name);
        $name = htmlspecialchars($name);
=======
        $review = securityCheck($review);
        $name = securityCheck($name);
>>>>>>> search
        $date = date("d-m-Y");
        if (inputReview($name, $date, $review, review) == TRUE)
        {
            header("Location: guestbook.php");
        } else $messages[] = "Такой логин уже есть";
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
                    getReview(10,review);
                    getPageButtons(review,10,$id);
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
                        <?php (isset($_SESSION['login']) ? print "Ваше имя: ".$_SESSION['login'] : print "Ваше имя: <input type='text' name='login'>") ?>
                        <textarea class="gb-input-textarea" name="review"></textarea>
                        <input class="gb-buttons" type="reset" value="Сбросить">
                        <input class="gb-buttons" type="submit" name="submit" value="Отправить отзыв">
                    </form>";
                </div>             
            </article>
            <?php include_once 'footer.php'; ?>
        </section>
    </body>
</html>
