<?php 
session_start();
include_once 'func.php';
include_once 'connect.php';
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
        <?php
        include 'header.php';
        include 'nav.php'; 
        ?>
        <article id='main'>
            <?php
            if (isset($_GET['genre']))
            {
                $genre = $_GET['genre'];
                $genre = mysql_real_escape_string($genre);
                $result = mysql_query("SELECT * FROM upload_books WHERE upload_books.genre = '$genre'");
                if (mysql_num_rows($result) > 0)
                {
                    $fetch = mysql_fetch_array($result);
                    do
                    {
                        print "<a class='catalog-links' href='page.php?id=".$fetch['id']."'><div class='catalog-content'>
                                <img src='uploads/".$fetch['img']."' alt='картинка'>
                                <p>".$fetch['book_name']."</p>
                                <p>".$fetch['author']."</p>
                              </div></a>";
                    }
                    while ($fetch = mysql_fetch_array($result));
                } else print "<h1>В данной категории пока ничего нет</h1>";
            } else print "<h1>Выберите категорию</h1>";
            ?>
        </article>
        <?php include 'footer.php'; ?>
    </section>    
</body>
</html>