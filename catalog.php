<?php
require_once 'func.php';
require_once 'connect.php';
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
    <script type="text/javascript" src="javascript/main_scripts.js"></script>
</head>
<body>
    <section id="container">
        <?php
        require_once 'header.php'; 
        require_once 'nav.php';
        ?>
        <article id='catalog_main'>
            <?php
            if (isset($_GET['genre']))
            {
                $num = 10; //<--- для смены кол-ва выводимых книг изменять это
                $_GET['genre'] = securityCheck($_GET['genre']);
                $query_cpb = "SELECT * FROM upload_books WHERE genre = '".$_GET['genre']."'";
                if(empty($_GET['page']) or $_GET['page'] < 0) $_GET['page'] = 1;
                $start = $_GET['page'] * $num - $num;
                $result = $mdb2->query("SELECT * FROM upload_books WHERE genre = '".$_GET['genre']."' LIMIT $start, $num");
                if ($result->numRows() > 0)
                {
                    include_once 'classes/PageButtons.php';
                    $catalog_buttons = new PageButtons($num, $query_cpb, 'genre='.$_GET['genre'], $mdb2);
                    $catalog_buttons->getButtons();
                    while ($row = $result->fetchRow())
                    {
                        print "<a href='page.php?id=".$row['id']."'>
                                <div class='bookbox' boolid='". $row['id'] ."'>
                                    <img src='uploads/".$row['img'].'.jpeg'."' alt='картинка'>
                                    <div class='description_pop-up' id='".$row['id']."' style='display:none'>
                                        <h6>".$row['book_name']."</h6>
                                        <span>".$row['author']."</span>
                                    </div>
                                </div>
                               </a>";
                    }
                } else print "<h1>В данной категории пока ничего нет</h1>";
            } else print "<h1>Выберите категорию</h1>";
            ?>
        </article>
        <?php require_once 'footer.php'; ?>
    </section>    
</body>
</html>