<?php
require_once 'connect.php';
require_once 'classes/PageButtons.php';
require_once 'func.php';
session_start();
header("Cache-Control: private, must-revalidate");
header("Vary: Content-ID");
header("Content-ID: " . md5($_GET['id']).'-'.$_GET['page']);
//header("Content-type: ");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <script type="text/javascript" src="javascript/main_scripts.js"></script>
    </head>
    <body style="background-image: none"> 
        <?php
        $num = 100;
        $_GET['page'] = intval($_GET['page']);
        $_GET['b'] = securityCheck($_GET['id']);
        @$content = file("uploads/".$_GET['b'].".txt");
        $totpag = count($content);
        $page = new PageButtons($num, $totpag);
//        $p = $page->getTotalPosts();
        $page->getBookPageButtons();
        if ($_GET['page'] == 0 || $_GET['page'] == 1) {
            $i = 0; 
        } else
            $i = ($_GET['page'] - 1) * $num;
        $end = $i + 100;
        print '<div style="width: 30%; float: left; height: 100%;">
                <form method="get" action="" style="position: fixed; margin-top: 200px;">
                    <input type="hidden" value='.$_GET['id'].' name="id">'.
                    '<input type="text" name="page" size="3" maxlength="3">
                    <input type="submit" value="ОК">
                </form>
               </div>';
        print '<div style="width: 40%; text-align: center; float: left;">';
        for ($i; $i < $end; $i++) {
            print '<p>'.$content[$i].'</p>';
        }
        print '</div>';
        print '<div style="width: 30%; float: right; text-align: center;">
                    <h1>Закладки</h1>
                    <ul>'.
                    //здесь будут закладки
                    '</ul>
               </div>';
        ?>
    </body>
</html>
