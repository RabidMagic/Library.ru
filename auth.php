<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Библиотека</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
    </head>
    <body>
        <section id="temp">
            <a href="index.php">Главная</a><br>
            <?php if (isset($_POST['login'])) 
            { 
                $login = $_POST['login']; 
                if ($login == '') { unset($login);} 
            }
            if (isset($_POST['password']))
            {
                $password = $_POST['password'];
                if ($password == '') { unset($password); }
            }
            if (empty($login) || empty($password))
            {
                die("Вы не ввели все данные");
            }
            $login = stripcslashes($login);
            $login = htmlspecialchars($login);
            $login = trim($login);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $password = trim($password);
            include 'bd.php';
            $result = mysql_query("SELECT * FROM users WHERE login = '$login'");
            $myrow = mysql_fetch_array($result);
            if ($myrow['login'] == $login)
            {
                if ($myrow['password'] == $password)
                {
                    $_SESSION['login'] = $myrow['login'];
                    $_SESSION['id'] = $myrow['id'];
                    echo 'Вы успешно вошли на сайт как '.$_SESSION['login'];
                } else { die("Неверный логин/пароль");};
            } else { die("Неверный логин/пароль");};
            
            ?>
            
        </section>
    </body>
</html>
