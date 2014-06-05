<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
$_SESSION['count']++;
if ($_SESSION['count'] == 1)
{
    $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <style>
            body { background-image: url(/img/background.jpg); background-size: cover; }
        </style>
    </head>
    <body>
        <section id="container">
            <article id="auth_main">
                <h1>Требуется авторизация!</h1>
                <?php
                if (!empty($_SESSION['messages']))
                {
                    $messages = $_SESSION['messages'];
                    displayErr($messages);
                    unset($_SESSION['messages']);
                }
                ?>
                <form action="login.php" method="post">
                    <table>
                        <tr>
                            <td>Логин: </td>
                            <td><input name="login" type="text"></td>
                        </tr>
                        <tr>
                            <td>Пароль: </td>
                            <td><input type="password" name="password"></td>
                        </tr>
                    </table>
                    <input type="submit" value="Войти">
                </form>
                <a href="registration.php"><button>Регистрация</button></a><br>
                <a href='index.php'><button>Главная</button></a><br>
            </article>
        </section>
    </body>
</html>
