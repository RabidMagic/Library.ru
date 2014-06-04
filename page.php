<?php 
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
session_start(); 
$_GET['id'] = securityCheck($_GET['id']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека | Каталог</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
        <script type="text/javascript" src="javascript/main_scripts.js"></script>
    </head>
    <body onload="pageLoaded();">
        <?php        include_once 'login_pop-up.php'; ?>
        <section id="container">
            <?php require_once 'header.php'; ?>
            <?php require_once 'nav.php'; ?>
            <article id="page_main">
                <?php
                $result = $mdb2->query("SELECT * FROM upload_books WHERE id = '".$_GET['id']."'");
                if ($result->numRows() == 1)
                {
                    $row = $result->fetchRow();
                    print "<img class='page_img' src='uploads/".$row['img']."' alt='картинка'>
                           <div id='description'>
                            <h1>".$row['book_name']."</h1>
                            <h3>".$row['author']."</h3>
                            <p>".$row['description']."</p>
                            <p><a href='".$row['url']."'>Скачка файла</a></p>
                            <div class='user-date-page'><p>Добавил: <b>".$row['login']."</b> Дата: <b>".$row['date']."</b></p></div>";
                    if (isset($_SESSION['stat_log']))
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
                    print  "</div>
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
                                   <form action='page_com_input_scr.php' method='post'>
                                        Ваш логин:".$_SESSION['login']."                
                                        <textarea class='page-comments-input-textarea' name='page-content'></textarea>
                                        <input type='hidden' name='page-b-id' value='".$_GET['id']."'>
                                        <input type='reset' value='Сбросить'>
                                        <input type='submit' value='Отправить'>
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
