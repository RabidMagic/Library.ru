<?php 
require_once 'func.php';
require_once 'connect.php';
require_once 'GetResults.php';
require_once 'PageButtons.php';
require_once 'FavBook.php';
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
        <style>
            #description p a { color: blue; text-decoration: underline; }
            h4 { text-align: center; }
            h1 { text-align: center; }
        </style>
    </head>
    <body onload="pageLoaded();">
        <section id="container">
            <?php require_once 'header.php'; ?>
            <?php require_once 'nav.php'; ?>
            <article id="page_main">
                <?php
                $result = $mdb2->query("SELECT * FROM upload_books WHERE id = '".$_GET['id']."'");
                if ($result->numRows() == 1)
                {
                    $row = $result->fetchRow();
                    print "<img class='page_img' src='uploads/".$row['img'].'.jpeg'."' alt='картинка'>
                           <div id='description'>
                            <h1>".$row['book_name']."</h1>
                            <h3>".$row['author']."</h3>
                            <p>".$row['description']."</p>
                            <a href='readbook.php?id=".$row['img']."'><button>Читать на сайте</button></a>
                            <div class='user-date-page'><p>Добавил: <b>".$row['login']."</b> Дата: <b>".$row['date']."</b></p></div>";
                    if (isset($_SESSION['stat_log']))
                    {
                        $check_fav = new FavBook($_SESSION['login']);
                        if ($check_fav->checkFav() === FALSE) {
                            print "<form action='fav-book-add.php' method='post'>
                                    <input type='hidden' value='".$_GET['id']."' name='id'>
                                    <input type='hidden' value='".$row['img']."' name='img'>
                                    <input type='hidden' value='".$row['book_name']."' name='title'>
                                    <input type='hidden' value='".$row['author']."' name='author'>
                                    <input type='submit' value='Добавить в Избранное'>
                                   </form>";
                        } else print "<form action='fav-book-del.php' method='post'>
                                        <input type='hidden' value='".$_GET['id']."' name='id'>
                                        <input type='submit' value='Удалить из Избранного'>
                                      </form>";
                        if ($_SESSION['us_group'] == 'admin') {
                            echo '<form method="post" action="bookdel.php">
                                <input type="hidden" name="id" value="'.$_GET['id'].'">
                                <input type="hidden" name="name" value="'.$row['img'].'">
                                <input type="hidden" name="genre" value="'.$row['genre'].'">
                                <input type="submit" value="Удалить">
                                </form>';
                        }
                    }
                    print  "</div>
                            <div class='page-comments-output'>";
                    if (!empty($messages)) { displayErr($messages); }
                    $num = 3; //<--- для смены кол-ва выводимых комментариев изменять это
                    $query = "SELECT * FROM book_comments WHERE book_id=".$_GET['id']." ORDER BY id DESC";
                    $page_review = new GetResults($num, $query, $mdb2);
                    $page_review->getReview();
                    $query = "SELECT * FROM book_comments WHERE book_id ='".$_GET['id']."'";
                    $page_pb = new PageButtons($num, $query, 'id='.$_GET['id'], $mdb2);
                    $page_pb->getButtons();
                    if ($_SESSION['stat_log'] == TRUE) 
                    {
                        print "</div>
                               <div class='page-comments-input'>
                                   <form action='page_com_input_scr.php' method='post'>
                                        Ваш логин:<b>".$_SESSION['login']."<b>                
                                        <textarea class='page-comments-input-textarea' name='page-content'></textarea>
                                        <input type='hidden' name='page-b-id' value='".$_GET['id']."'>
                                        <input type='reset' value='Сбросить'>
                                        <input type='submit' value='Отправить'>
                                   </form>
                               </div>";
                    } else print "<br><h4>Авторизируйтесь, чтобы оставлять комментарии</h4>";
                        print "<div class='clearfix'></div>";
                } else print "<h1>Искомой книги найдено не было</h1>";
                ?>
            </article>
            <?php require_once 'footer.php'; ?>
        </section>
    </body>
</html>
