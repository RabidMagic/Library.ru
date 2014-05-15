<?php 
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
session_start(); 
$_GET['id'] = mysql_real_escape_string($_GET['id']);
if (isset($_POST['page-com-input']))
{
    if (empty($_SESSION['login']))
    {
        $messages[] = "Не указан логин";
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
        $query = "INSERT INTO book_comments (login, content, date, book_id) VALUES ('$login', '$content', '$date', '$book_id')";
        if (Input() == TRUE)
        {
            header("Location: page.php?id=".$_POST['page-b-id']);
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
            <?php require_once 'header.php'; ?>
            <?php require_once 'nav.php'; ?>
            <article id="main">
                <?php
                $result = mysql_query("SELECT * FROM upload_books WHERE id = '".$_GET['id']."'");
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
                                            <input type='hidden' value='".$_GET['id']."' name='book_id'>
                                            <input type='submit' value='Добавить в Избранное'>
                                           </form>";
                                } else print "<form action='fav-book-del.php' method='post'>
                                                <input type='hidden' value='".$_SESSION['login']."' name='fav-login'>
                                                <input type='hidden' value='".$_GET['id']."' name='fav-b-id'>
                                                <input type='submit' value='Удалить'>
                                              </form>";
                            }
                    print "</div>
                           <div class='page-comments-output'>";
                            if (!empty($messages)) { displayErr($messages); }
                            $num = 3; //<--- для смены кол-ва выводимых комментариев изменять это
                            $query = "SELECT * FROM book_comments WHERE book_id=".$_GET['id']." ORDER BY id DESC";
                            $page_review = new GetResults($num, $query, $mdb2);
                            $page_review->getReview();
                            $query = "SELECT * FROM book_comments WHERE book_id ='".$_GET['id']."'";
                            $page_pb = new PageButtons($num, $query, $mdb2);
                            $page_pb->getBookPageButtons();
                    if ($_SESSION['stat_log'] == TRUE) 
                    {
                        print "</div>
                               <div class='page-comments-input'>
                                   <form action='' method='post'>
                                        Ваш логин:".$_SESSION['login']."                
                                        <textarea class='page-comments-input-textarea' name='page-content'></textarea>
                                        <input type='hidden' name='page-b-id' value='".$_GET['id']."'>
                                        <input type='reset' value='Сбросить'>
                                        <input type='submit' name='page-com-input' value='Отправить'>
                                   </form>
                               </div>";
                    } else print "<br>Авторизируйтесь, чтобы оставлять комментарии";
                        print "<div class='clearfix'></div>";
                } else print "Искомой книги найдено не было";
                ?>
            </article>
            <?php require_once 'footer.php'; ?>
        </section>
    </body>
</html>
