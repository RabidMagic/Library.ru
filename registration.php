<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Библиотека | Регистрация</title>
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <div id="reg_page">
            <?php
                if (isset($_POST['posted']))
                {
                    if (isset($_POST['login'])) 
                        { 
                        $login = $_POST['login']; 
                        if ($login == '') { unset($login);} 
                        }
                    if (isset($_POST['password'])) 
                        { 
                        $password=$_POST['password'];
                        if ($password == '') { unset($password); }
                        }
                    if (empty($login) or empty($password))
                        {
                            exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
                        }
                    $login = stripslashes($login);
                    $login = htmlspecialchars($login);
                    $password = stripslashes($password);
                    $password = htmlspecialchars($password);
                    $login = trim($login);
                    $password = trim($password);
                    include ("bd.php");
                    $result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
                    if ($result)
                        {
                        $myrow = mysql_fetch_array($result);
                        if (!empty($myrow['id'])) 
                            {
                            exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
                            }
                        $result2 = mysql_query ("INSERT INTO users (login,password) VALUES('$login','$password')");
                        if ($result2=='TRUE')
                            {
                            echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='index.php'>Главная страница</a>";
                            }
                        else {
                            echo "Ошибка! Вы не зарегистрированы.";
                            }
                        } else {
                            die ("Ошибка");
                            }
                    } else {
                        echo '<form action="registration.php" method="post">';
                        echo '<input type="hidden" name="posted" value="true">';
                        echo '<h1>Регистрация</h1>';
                        echo '<p>Ваш логин:<input type="text" name="login" size="15" maxlength="15"><br>';
                        echo 'Ваш пароль:<input type="password" name="password" size="15" maxlength="15"<br></p>';
                        echo '<input type="submit" value="Зарегистрироваться">';
                        echo '</form>';
                        }
            ?>                    
        </div>
    </body>
</html>
