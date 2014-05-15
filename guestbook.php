<?php
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
session_start();
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
        $review = securityCheck($review);
        $name = securityCheck($name);
        $date = date("d-m-Y");
        $query = "INSERT INTO кумшуц (login, content, date) VALUES ('$name', '$review', '$date')";
        if (Input($query) == TRUE)
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
            <?php require_once 'header.php'; ?>
            <article id="main">
                <div class="gb-output">
                    <?php
                    $num = 3; //<--- для смены кол-ва выводимых комментариев изменять это
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
                        <?php (isset($_SESSION['login']) ? print "Ваше имя: ".$_SESSION['login'] : print "Ваше имя: <input type='text' name='login'>") ?>
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
