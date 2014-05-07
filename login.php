<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['submit']))
{
    $_POST['login'] = htmlspecialchars($_POST['login']);
    $_POST['password'] = htmlspecialchars($_POST['password']);
    field_validator("'Логин'", $_POST['login'], "alphanumeric", 4, 32);
    field_validator("'Пароль'", $_POST['password'], "string", 4, 16);
    if (checkUser($_POST['login'], $_POST['password']) === TRUE)
    {
        $messages[] = "Такого пользователя не существует";
    }
    if (empty($messages))
    {
        if (!reMemberSess($fetch['login'], $fetch['password']))
        {
            $messages[] = "Ошибка при подключении";
        }
        header("Location: account.php");
    }
}
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
                if (!empty($messages))
                {
                    displayErr($messages);
                }
                ?>
                <form action="" method="post">
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
                    <input type="submit" name="submit" value="Войти">
                </form>
                <a href="registration.php">Регистрация</a><br>
                <a href='index.php'>Главная</a><br>
            </article>
        </section>
        <?php include 'footer.php' ?> 
    </body>
</html>
