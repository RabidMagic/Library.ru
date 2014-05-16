<?php
require_once 'func.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Регистрация</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <article id="main">
                <form action='reg_scr.php' method='post'>
                    <h1>Регистрация</h1>
                    <?php
                    if (!empty($_SESSION['messages']))
                    {
                        displayErr($_SESSION['messages']);
                        unset($_SESSION['messages']);
                    }
                    ?>
                    <table>
                        <tr>
                            <td>Ваш логин:</td>
                            <td><input type='text' name='login' size='16' maxlength='16'></td>
                        </tr>
                        <tr>
                            <td>Ваш пароль:</td>
                            <td><input type='password' name='password' size='16' maxlength='16'></td>
                        </tr>
                        <tr>
                            <td>Повторите пароль:</td>
                            <td><input type='password' name='password2' size='16' maxlength='16'></td>
                        </tr>
                        <tr>
                            <td>Ваша дата рождения:</td>
                            <td><?php setBirthdate(); ?></td>
                        </tr>
                        <tr>
                            <td>Ваш пол:</td>
                            <td><input type='radio' name='gender' value='Мужской'>Мужской<br><input type='radio' name='gender' value='Женский'>Женский</td>
                        </tr>
                        <tr>
                            <td>Ваш e-mail:</td>
                            <td><input type='text' name='email'></td>
                        </tr>
                        <tr>
                            <td>Вы робот?</td>
                            <td><input type='radio' name='checkbot' value='yes' checked>Да<br><input type='radio' name='checkbot' value='no'>Нет</td>
                        </tr>
                    </table>
                    <input type='submit' value='Зарегистрироваться' name='reg'>
                </form>
                <a href="index.php"><button>На главную</button></a>
            </article>
        </section>    
    </body>
</html>
