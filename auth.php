<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <article id="main">
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
       <?php print "<input type='hidden' name='auth-hid-ref'>" ?>
                    <input type="submit" value="Войти">
                </form>
                <a href="registration.php">Регистрация</a><br>
                <a href='index.php'>Главная</a><br>
            </article>
        </section>
        <?php include 'footer.php' ?> 
    </body>
</html>
