<?php
//Подключение к БД
function connectToDb()
{
    global $link, $dbhost, $dbnm, $dbpwd, $dbuser;
    $link = mysql_connect($dbhost, $dbuser, $dbpwd);
    mysql_select_db($dbnm, $link);
}
//Создание нового пользователя
function newUser($login, $password, $gender, $birthdate, $email)
{
    global $link;
    $group = user;
    $password = md5(md5($password));
    $query = "INSERT INTO users (login, password, gender, birthdate, email, us_group) VALUES ('$login', '$password', '$gender', '$birthdate', '$email', '$group')";
    $result = mysql_query($query, $link);
    return TRUE;
}
//проверка состояния сессии
function checkLogIn($stat)
{
    switch($stat)
    {
        case "yes":
            if (!isset($_SESSION['stat_log']))
            {
                header("Location: login.php");
            }
            break;
        case "no":
            if (isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE)
            {
                header("Location: account.php");
            }
            break;
    }
    return TRUE;
}
//Процесс логина
function reMemberSess($login, $password)
{
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['stat_log'] = TRUE;
    return TRUE;
}
//Процесс логаута
function clearSess()
{
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    unset($_SESSION['stat_log']);
    session_destroy();
    return TRUE;
}
//Проверка пользователя по БД
function checkUser($login, $password)
{
    global $link, $fetch;
    $password = md5(md5($password));
    $query = "SELECT login, password FROM users WHERE login='$login' && password='$password'";
    $result = mysql_query($query, $link);
    if (mysql_num_rows($result) == 1)
    {
        $fetch = mysql_fetch_array($result);
        return $fetch;
    }
    return TRUE;
}
//Проверка даты
function checkBirthDate($birthdate)
{
    global $messages;
    $ex = explode("-", $birthdate);
    $month = $ex[0];
    $day = $ex[1];
    $year = $ex[2];
    if (date("Y") > $year)
    {
        if (checkdate($month, $day, $year))
        {
            return TRUE;
        } else {
            $messages[] = "Введённая Вами дата некорректна";
            return FALSE;
        }
    } else {
        $messages[] = "Год рождения не может быть больше текущего года";
        return FALSE;
    }
}
//Проверка введённой информации
//$field_descr - описание поля, которое будет выводиться при ошибках;
//$field_data - передаваемая для проверки переменная;
//$field_type - тип поля. Типы описаны в массиве $data_types внутри функции;
//$min_length и $max_length - минимальные и максимальные возможные длины полей;
//$field_required - проверка на обязательность;
function field_validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1) 
{
    global $messages;
    if(!$field_data && !$field_required){ return; }
    $field_ok=false;
    $email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
    $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";
    $data_types=array(
        "email"=>$email_regexp,
        "digit"=>"^[0-9]$",
        "number"=>"^[0-9]+$",
        "alpha"=>"^[a-zA-Z]+$",
        "alpha_space"=>"^[a-zA-Z ]+$",
        "alphanumeric"=>"^[a-zA-Z0-9]+$",
        "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
        "string"=>""
    );
    if ($field_required && empty($field_data))
    {    
        $messages[] = "Поле $field_descr является обязательным";
        return;
    }
    if ($field_type == "string")
    {
        $field_ok = true;
    } else {
        $field_ok = ereg($data_types[$field_type], $field_data);
    }
    if (!$field_ok)
    {
        $messages[] = "Пожалуйста введите нормальное значение $field_descr.";
        return;
    }
    if ($field_ok && ($min_length > 0))   
    {
        if (strlen($field_data) < $min_length)
        {
            $messages[] = "$field_descr должен быть не короче $min_length символов.";
            return;
        }
    }
    if ($field_ok && ($max_length > 0))
    {
        if (strlen($field_data) > $max_length)
        {
            $messages[] = "$field_descr не должен быть длиннее $max_length символов.";
            return;
        }
    }
}
//Отображение ошибок
function displayErr($messages)
{
    print "<ul>\n";
    foreach ($messages as $msg)
    {
        print "<li>$msg</li>\n";
    }
    print "</ul>";
}
//Вывод обновлений из БД
function showNews()
{
    $result = mysql_query("SELECT * FROM upload_books ORDER BY id DESC LIMIT 0,3");
    if (mysql_num_rows($result) > 0)
    {
        $fetch = mysql_fetch_array($result);
        do
        {
            print "<div class='newble'>
                    <img src='uploads/".$fetch['img']."' alt='картинка'>
                    <div class='description'>
                        <h1>".$fetch['book_name']."</h1>
                        <h3>".$fetch['author']."</h3>
                    </div>

                </div>";
        }
        while ($fetch = mysql_fetch_array($result));
    } else print "<h2>Здесь пока нет новостей</h2>";
}
//Вывод жанров из БД
function outputGenres()
{
    global $link;
    $query = "SELECT genre FROM genres";
    $result = mysql_query($query, $link);
    $a = mysql_num_rows($result);
    if (mysql_num_rows($result) > 0)
    {
        while ($fetch = mysql_fetch_row($result))
        {
            foreach ($fetch as $f)
            {
                print "<option>$f</option>\n";
            }
        }
    }
}
//Проверка файла и загрузка его на сервер
//$name - имя поля в форме(обязательно указывать в одинарных кавычках!);
//$type - MIME-тип для проверки(string-тип);
//$size - орграничение на размер файла;
//$uploaddir - директория для хранения файла;
function uploadFile($name, $type, $size, $uploaddir)
{
    global $messages, $uploadfile;
    if (!($_FILES[$name]['type'] == $type))
    {
        $messages[] = "Неверное расширение файла";
    }
    if ($_FILES[$name]['size'] > $size)
    {
        $messages[] = "Недопустимый размер файла";
    }
    if (empty($messages))
    {
        $rand = rand();
        $rand1 = rand(); 
        $uploadfile = $rand . md5(basename($_FILES[$name]['name'])) . $rand1;
        if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir . $uploadfile))
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
