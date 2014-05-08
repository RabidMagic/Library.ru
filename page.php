<?php 
session_start(); 
include_once 'func.php';
include_once 'connect.php';
$id = $_GET['id'];
$id = mysql_real_escape_string($id);
if (isset($_POST['page-com-input']))
{
    if (empty($_SESSION['login']) && empty($_POST['login']))
    {
        $messages[] = "Не указан логин";
    } else if (isset($_POST['login']))
    {
        if (checkName($_POST['login']) == TRUE)
        {
            $login = $_POST['login'];
        } else $messages[] = "Такой логин уже есть";
    } else $login = $_SESSION['login'];
    if (empty($_POST['page-content']))
    {
        $messages[] = "Поле отзыва не должно быть пустым";
    }
    if (empty($messages))
    {
        $content = $_POST['page-content'];
        $content = securityCheck($content);
        $login = securityCheck($login);
        $date = date("d-m-Y");
        if (inputComment($login, $date, $content, $_POST['page-b-id'], book_comments) == TRUE)
        {
            header("Location: page.php?id=$id");
        } 
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека | Каталог</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <?php include 'header.php'; ?>
            <?php include 'nav.php'; ?>
            <article id="main">
                <?php
                $result = mysql_query("SELECT * FROM upload_books WHERE id = '$id'");
                $fetch = mysql_fetch_array($result);
                if (mysql_num_rows($result) === 1)
                {
                    print "<img src='uploads/".$fetch['img']."' alt='картинка'>
                           <div>
                            <h1>".$fetch['book_name']."</h1>
                            <h3>".$fetch['author']."</h3>
                            <p>".$fetch['description']."</p>
                            <div class='user-date-page'><p>Добавил: <b>".$fetch['login']."</b> Дата: <b>".$fetch['date']."</b></p></div>";
                            ?>
                            <?php 
                            if (isset($_SESSION['login']))
                            {
                                if (checkBookFav() == TRUE)
                                {
                                    print "<form action='fav-book-add.php' method='post'>
                                            <input type='hidden' value='$id' name='page_id'>
                                            <input type='hidden' value='".$fetch['id']."' name='book_id'>
                                            <input type='submit' value='Добавить в Избранное'>
                                           </form>";
                                } else print "<form action='fav-book-del.php' method='post'>
                                                <input type='hidden' value='".$_SESSION['login']."' name='fav-login'>
                                                <input type='hidden' value='".$fetch['id']."' name='fav-b-id'>
                                                <input type='submit' value='Удалить'>
                                              </form>";
                            }
                    print "</div>
                           <div class='page-comments-output'>";
                            if (!empty($messages)) { displayErr($messages); }
                            getComment(5, $fetch['id']);
                            getPageButtons(book_comments, 5, $id);
                     print "</div>
                            <div class='page-comments-input'>
                                <form action='' method='post'>
                                    Ваш логин:"?><?php (isset($_SESSION['login']) ? print $_SESSION['login'] : print '<input type="text" name="login">');?>
                                    <?php
                                    print "<textarea class='page-comments-input-textarea' name='page-content'></textarea>
                                    <input type='hidden' name='page-b-id' value='".$fetch['id']."'>
                                    <input type='reset' value='Сбросить'>
                                    <input type='submit' name='page-com-input' value='Отправить'>
                                </form>
                            </div>
                            <div class='clearfix'></div>";
                } else print "Искомой книги найдено не было";
                ?>
            </article>
            <?php include 'footer.php'; ?>
        </section>
    </body>
</html>
