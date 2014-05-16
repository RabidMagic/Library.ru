<?php
require_once 'MDB2.php';
//Проверка имени на занятость
function checkName($login) {
    global $messages, $mdb2;
    $query = "SELECT login FROM users WHERE login='$login'";
    $result = $mdb2->query($query);
    if ($result->numRows() > 0)
    {
        return FALSE;
    } else return TRUE;
}
//Проверка нахождения книги в Избранном
function checkBookFav() {
    global $mdb2;
    $query = "SELECT * FROM favourites WHERE book_id='".$_GET['id']."' && login='".$_SESSION['login']."'";
    $result = $mdb2->query($query);
    if ($result->numRows() == 0)
    {
        return TRUE;
    } else return FALSE;
}
//Удаление всего лишнего
function securityCheck($var) {
    $var = trim($var);
    $var = htmlspecialchars($var);
    return $var;
}
//Создание нового пользователя
function newUser($login, $password, $gender, $birthdate, $email, $group=user) {
    global $mdb2;
    $password = md5(md5($password));
    $query = "INSERT INTO users (login, password, gender, birthdate, email, us_group) VALUES ('$login', '$password', '$gender', '$birthdate', '$email', '$group')";
    $mdb2->exec($query);
    return TRUE;
}
//проверка состояния сессии
function checkLogIn() {
    if (empty($_SESSION['stat_log']))
    {
        header("Location: auth.php");
    }
    return FALSE;
}
//Процесс логина
function setSession($login, $password) {
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['stat_log'] = TRUE;
    return TRUE;
}
//Процесс логаута
function flushSession() {
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    unset($_SESSION['stat_log']);
    session_destroy();
    return TRUE;
}
//Проверка пользователя по БД
function checkUser($login, $password) {
    global $mdb2;
    $password = md5(md5($password));
    $query = "SELECT login, password FROM users WHERE login='$login' && password='$password'";
    $result = $mdb2->query($query);
    if ($result->numRows() == 1)
    {
        $fetch =& $result->fetchRow();
        return $fetch;
    }
    return TRUE;
}
//Проверка введённой информации
//$field_descr - описание поля, которое будет выводиться при ошибках;
//$field_data - передаваемая для проверки переменная;
//$field_type - тип поля. Типы описаны в массиве $data_types внутри функции;
//$min_length и $max_length - минимальные и максимальные возможные длины полей;
//$field_required - проверка на обязательность;
function field_validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1)  {
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
function displayErr($messages) {
    print "<ul>\n";
    foreach ($messages as $msg)
    {
        print "<li>$msg</li>\n";
    }
    print "</ul>";
}
//Вывод жанров из БД
function outputGenres() {
    global $mdb2;
    $query = "SELECT genre FROM genres";
    $result = $mdb2->query($query);
    if ($result->numRows() > 0)
    {
        while ($row = $result->fetchRow())
        {
            foreach ($row as $value)
            {
                print "<option>$value</option>\n";
            }
        }
    }
}
//Проверка файла и загрузка его на сервер
//$name - имя поля в форме(обязательно указывать в одинарных кавычках!);
//$type - MIME-тип для проверки(string-тип);
//$size - орграничение на размер файла;
//$uploaddir - директория для хранения файла;
function uploadFile($name, $type, $size, $uploaddir) {
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
//Отправка комментария/отзыва в базу
function Input($query) {
    global $mdb2;
    $mdb2->exec($query);
    return TRUE;
}
//Вывод формы выбора даты рождения
function setBirthdate() {
    echo "<select name='reg-b-day'>";
    for ($d = 1; $d < 32; $d++)
    {
        echo "<option>".(strlen($d)==1 ? '0'.$d : $d)."</option>";
    }
    echo "</select>
           <select name='reg-b-month'>";
    for ($m = 1; $m < 13; $m++)
    {
        echo "<option>".(strlen($m)==1 ? '0'.$m : $m)."</option>";
    }
    echo "</select>";
    $date = date("Y");
    $miny = $date - 80;
    $maxy = $date - 10;
    echo "<select name='reg-b-year'>";
    for ($miny; $miny <= $maxy; $miny++)
    {
        echo "<option>$miny</option>";
    }
    echo "</select>";
}
//Перевод в верхний регистр первого слова строки
function mb_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}
?>
