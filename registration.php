<?php
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['reg']))
{
    $messages = array();
    field_validator("'Логин'", $_POST["login"], "alphanumeric", 4, 32);
    field_validator("'Пароль'", $_POST["password"], "string", 4, 16);
    field_validator("'Подтверждение пароля'", $_POST["password2"], "string", 4, 16);
    field_validator("e-mail", $_POST['email'], "email");
    $login = mysql_real_escape_string($_POST['login']);
    $result = mysql_query("SELECT login FROM users WHERE login = '$login'", $link);
    if (mysql_num_rows($result) != 0)
    {
        $messages[] = "Такой логин уже есть";
    }
    if (strcmp($_POST['password'], $_POST['password2']))
    {
        $messages[] = "Ваши пароли не совпадают";
    }
    if (empty($_POST['gender']))
    {
        $messages[] = "Вы не выбрали пол";
    }
    if (!empty($_POST['reg-b-month']) && !empty($_POST['reg-b-day']) && !empty($_POST['reg-b-year']))
    {
        if (!checkdate($_POST['reg-b-month'], $_POST['reg-b-day'], $_POST['reg-b-year']))
        {
            $messages[] = "Введена некорректная дата";
        }
    } else $messages[] = "Вы не ввели дату рождения";
    if (isset($_POST['email']))
    {
        $email = mysql_real_escape_string($_POST['email']);
        $result = mysql_query("SELECT email FROM users WHERE email = '$email'", $link);
        if (mysql_num_rows($result) != 0)
        {
            $messages[] = "Этот e-mail уже занят";
        }
    } else {
        $messages[] = "Вы не ввели e-mail";
    }
    if ($_POST['checkbot'] == 'yes')
    {
        $messages[] = "Проверка показала, что вы робот :)";
    }
    if (empty($messages))
    {
        $birthdate = array($_POST['reg-b-day'], $_POST['reg-b-month'], $_POST['reg-b-year']);
        $birthdate = implode("-", $birthdate);
        newUser($_POST['login'], $_POST['password'], $_POST['gender'], $birthdate, $_POST['email']);
        reMemberSess($_POST['login'], $_POST['password']);
        header("Location: index.php");
    }    
}
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
                <form action='' method='post'>
                    <h1>Регистрация</h1>
                    <?php
                    if (!empty($messages))
                    {
                        displayErr($messages);
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
            </article>
        </section>    
    </body>
</html>
