<?php
require_once 'func.php';
require_once 'connect.php';
require_once 'classes.php';
session_start();
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
        require_once 'header.php';
        require_once 'nav.php'; 
        ?>
        <article id='main'>
            <?php
            if (isset($_GET['genre']))
            {
                $num = 1; //<--- для смены кол-ва выводимых книг изменять это
                $query_cpb = "SELECT * FROM upload_books WHERE genre = '".$_GET['genre']."'";
                $catalog_buttons = new PageButtons($num, $query_cpb, $mdb2);
                $_GET['genre'] = securityCheck($_GET['genre']);
                if(empty($_GET['page']) or $_GET['page'] < 0) $_GET['page'] = 1;
                $start = $_GET['page'] * $num - $num;
                $result = $mdb2->query("SELECT * FROM upload_books WHERE genre = '".$_GET['genre']."' LIMIT $start, $num");
                if ($result->numRows() > 0)
                {
                    $catalog_buttons->getCatalogPageButtons();
                    while ($row = $result->fetchRow())
                    {
                        print "<a class='catalog-links' href='page.php?id=".$row['id']."'><div class='catalog-content'>
                                <img src='uploads/".$row['img']."' alt='картинка'>
                                <p>".$row['book_name']."</p>
                                <p>".$row['author']."</p>
                              </div></a>";
                    }
                    $catalog_buttons->getCatalogPageButtons();
                } else print "<h1>В данной категории пока ничего нет</h1>";
            } else print "<h1>Выберите категорию</h1>";
            ?>
        </article>
        <?php require_once 'footer.php'; ?>
    </section>    
</body>
</html>