<?php
require_once 'MDB2.php';
//Проверка имени на занятость
function checkName($login) {
    global $messages, $mdb2;
    $result = $mdb2->query("SELECT login FROM users WHERE login='$login'");
    if ($result->numRows() > 0)
    {
        return FALSE;
    } else return TRUE;
}
//Удаление всего лишнего
function securityCheck($var) {
    $var = trim($var);
    $var = htmlspecialchars($var);
    $var = addslashes($var);
    return $var;
}
//Создание нового пользователя
function newUser($login, $password, $gender, $birthdate, $email, $group=user) {
    global $mdb2;
    $password = md5(md5($password));
    $mdb2->exec("INSERT INTO users (login, password, gender, birthdate, email, us_group) VALUES ('$login', '$password', '$gender', '$birthdate', '$email', '$group')");
    return TRUE;
}
//Процесс логина
function setSession($login, $password, $us_group) {
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['us_group'] = $us_group;
    $_SESSION['stat_log'] = TRUE;
    return TRUE;
}
//Процесс логаута
function flushSession() {
    session_unset();
    session_destroy();
    return TRUE;
}
//Проверка пользователя по БД
function checkUser($login, $password) {
    global $mdb2;
    $password = md5(md5($password));
    $result = $mdb2->query("SELECT login, password,us_group FROM users WHERE login='$login' && password='$password'");
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
    $email_regexp="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
    $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
    $url = "~^(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}".  
   "(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|".  
   "org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?".  
   "!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&".  
   "?+=\~/-]*)?(?:#[^ '\"&<>]*)?$~i";
    $data_types=array(
        "email"=>$email_regexp,
        "digit"=>"/^[0-9]$/",
        "number"=>"/^[0-9]+$/",
        "alpha"=>"/^[a-zA-Z]+$/",
        "alpha_space"=>"/^[a-zA-Z ]+$/",
        "alphanumeric"=>"/^[a-zA-Z0-9]+$/",
        "alphanumeric_space"=>"/^[a-zA-Z0-9 ]+$/",
        "string"=>"",
        "cyrillic"=>"/^[а-яА-Я]+$/u",
        "cyrillic_text"=>"/^[а-яА-Я ]+$/u",
        "url"=>$url
    );
    if ($field_required && empty($field_data))
    {    
        $messages[] = "Поле является обязательным: '$field_descr'";
        return;
    }
    if ($field_type == "string")
    {
        $field_ok = true;
    } else {
        $field_ok = preg_match($data_types[$field_type], $field_data);
    }
    if (!$field_ok)
    {
        $messages[] = "Неверно введено значение: '$field_descr'";
        return;
    }
    if ($field_ok && ($min_length > 0))   
    {
        if (strlen($field_data) < $min_length)
        {
            $messages[] = "Поле '$field_descr' должно быть не короче $min_length символов.";
            return;
        }
    }
    if ($field_ok && ($max_length > 0))
    {
        if (strlen($field_data) > $max_length)
        {
            $messages[] = "Поле '$field_descr' не должно быть длиннее $max_length символов.";
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
//Создание случайной строки;
function setRandomString($min, $max = 20) {
    global $mdb2;
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $length = rand($min, $max);
    $numChars = strlen($chars);
    for ($i = 0; $i < $length; $i++) 
    {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}
//Перевод русских символов в транслит;
function getStrTranslit($string) {
    $translit = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'j', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => "'", 'ы' => 'y', 'ъ' => '',
            'э' => "e'", 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'YO', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'J', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH',
            'Ь' => "'", 'Ы' => "Y'", 'Ъ' => '',
            'Э' => "E'", 'Ю' => 'YU', 'Я' => 'YA');
    return $str = iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $translit));
}
//Проверка файла и загрузка его на сервер
function uploadFile($name, $uploadfile) {
    global $messages, $mdb2, $log;
    $mime = explode('/', $_FILES[$name]['type']);
    switch ($mime[0]) {
        case 'image':
            $uploaddir = 'uploads/';
            $uploadfile .= '.jpeg';
            if ($_FILES[$name]['size'] > 3000000)
            {
                $messages[] = "Недопустимый размер файла";
                return FALSE;;
            }
            $size = getimagesize($_FILES[$name]['tmp_name']);
            if ($size[0] != 0 && $size[1] != 0) {
                $img = imagecreatetruecolor(250, 385);
                switch ($mime[1]) {
                    case 'png':
                        $fp = imagecreatefrompng($_FILES[$name]['tmp_name']);
                        break;
                    case 'jpeg':
                        $fp = imagecreatefromjpeg($_FILES[$name]['tmp_name']);
                        break;
                    default:
                        $messages[] = 'Неверное расширение файла';
                        break;
                }
                if ($img) {
                    if (!imagecopyresampled($img, $fp, 0, 0, 0, 0, 250, 385, $size[0], $size[1])) {
                        $log .= ' failed imagecopyresampled;';
                    }
                } else {
                    $log .= ' failed imagecreatetruecolor;';
                    $messages[] = '<h2 style="color: red">Внимание! Ошибка загрузки!</h2>';
                }
            }
            if (empty($log) && empty($messages)) {
                imagejpeg($img, $uploaddir.$uploadfile);
                return TRUE;
            }
            break;
        case 'text':
            $uploaddir = 'uploads/';
            $uploadfile .= '.txt';
            if ($_FILES[$name]['size'] > 3000000) {
                $messages[] = 'Недопустимый размер файла';
                return FALSE;
            }
            switch ($mime[1]) {
                case 'plain':
                    $filename = $_FILES[$name]['tmp_name'];
                    $fp = fopen($filename, 'r');
                    while (!feof($fp)) {
                        $buff[] = fgetss($fp);
                    }
                    if (fclose($fp)) {
                        $newfp = fopen($uploaddir.$uploadfile, 'a');
                        foreach ($buff as $value) {
                            fwrite($newfp, $value);
                        }
                        if (fclose($newfp)) {
                            return TRUE;
                        }
                    } else {
                        $messages[] = 'Ошибка! Невозможно загрузить файл!';
                        return FALSE;
                    }
                    break;
                default:
                    $messages[] = 'Неверное расширение файла';
                    return FALSE;
                    break;
            }
            break;
        default:
            $messages[] = "Неверный тип файла";
            return FALSE;
            break;
    }
    return FALSE;
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
    echo "<option disabled selected>ДД</option>";
    for ($d = 1; $d < 32; $d++)
    {
        echo "<option>".(strlen($d)==1 ? '0'.$d : $d)."</option>";
    }
    echo "</select>
           <select name='reg-b-month'> 
           <option disabled selected>ММ</option>";
    for ($m = 1; $m < 13; $m++)
    {
        echo "<option>".(strlen($m)==1 ? '0'.$m : $m)."</option>";
    }
    echo "</select>";
    $date = date("Y");
    $miny = $date - 80;
    $maxy = $date - 10;
    echo "<select name='reg-b-year'>
            <option disabled selected>ГГГГ</option>";
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
