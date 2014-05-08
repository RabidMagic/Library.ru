<?php
//Проверка имени на занятость
function checkName($login) {
    global $link, $messages;
    $check = preg_match('/^[a-zA-Z0-9]+$/', $login);
    if (!$check)
    {
        $messages[] = "Введите верный логин";
    }
    $login = mysql_real_escape_string($login);
    $login = htmlspecialchars($login);
    $query = "SELECT login FROM users WHERE login='$login'";
    $result = mysql_query($query, $link);
    if (mysql_num_rows($result) > 0)
    {
        return FALSE;
    } else return TRUE;
}
//Подключение к БД
function connectToDb() {
    global $link, $dbhost, $dbnm, $dbpwd, $dbuser;
    $link = mysql_connect($dbhost, $dbuser, $dbpwd);
    mysql_select_db($dbnm, $link);
}
//Создание нового пользователя
function newUser($login, $password, $gender, $birthdate, $email) {
    global $link;
    $group = user;
    $password = md5(md5($password));
    $query = "INSERT INTO users (login, password, gender, birthdate, email, us_group) VALUES ('$login', '$password', '$gender', '$birthdate', '$email', '$group')";
    $result = mysql_query($query, $link);
    return TRUE;
}
//проверка состояния сессии
function checkLogIn() {
    if (!isset($_SESSION['stat_log']))
    {
        header("Location: auth.php");
    }
    return TRUE;
}
//Процесс логина
function reMemberSess($login, $password) {
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['stat_log'] = TRUE;
    return TRUE;
}
//Процесс логаута
function clearSess() {
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    unset($_SESSION['stat_log']);
    session_destroy();
    return TRUE;
}
//Проверка пользователя по БД
function checkUser($login, $password) {
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
//Вывод новостей из БД
//1 - вывод книг из базы;
//2 - вывод новостей;
function showNews($case) {
    switch ($case)
    {
        case '1':
            $result = mysql_query("SELECT * FROM upload_books ORDER BY id DESC LIMIT 0,3");
            if (mysql_num_rows($result) > 0)
            {
                $fetch = mysql_fetch_array($result);
                do
                {
                    print "<div class='newble'>
                            <a href='page.php?id=".$fetch['id']."'><img src='uploads/".$fetch['img']."' alt='картинка'>
                            <div class='description'>
                                <h1>".$fetch['book_name']."</h1>
                                <h3>".$fetch['author']."</h3>
                            </div>
                            <div class='clearfix'></div></a>
                        </div>";
                }
                while ($fetch = mysql_fetch_array($result));
            } else print "<h2>Здесь пока нет новостей</h2>";
            break;
        case '2':
            $result = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 0,3");
            if (mysql_num_rows($result) > 0)
            {
                $fetch = mysql_fetch_array($result);
                do
                {
                    print "<div class='news'>
                                <h1>".$fetch['header']."</h1>
                                <p>".$fetch['desc']."</p>
                           </div>";
                }
                while ($fetch = mysql_fetch_array($result));
            }
            break;
    }
}
//Вывод жанров из БД
function outputGenres() {
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
//Вывод комментария с постраничностью
//$num - количество выводимых страниц;
function getReview($num, $table) {
    global $link;
    @$page = $_GET['page'];
    if(empty($page) or $page < 0) $page = 1;
    $start = $page * $num - $num;
    $query = "SELECT * FROM $table ORDER BY id DESC LIMIT $start,$num";
    $result = mysql_query($query, $link);
    if (mysql_num_rows($result) > 0)
    {
        $fetch = mysql_fetch_array($result);
        do
        {
            print "<div>
                    Имя: ".$fetch['login']." Дата: ".$fetch['date']."
                    <p>".$fetch['content']."</p>
                   </div>";
        } 
        while ($fetch = mysql_fetch_array($result));       
    } else print "Пока здесь нет отзывов, но Вы можете быть первым";
}
//Ввод отзыва в базу
function inputReview($login, $date, $content, $table) {
    global $link;
    $query = "INSERT INTO $table (login, content, date) VALUES ('$login', '$content', '$date')";
    $result = mysql_query($query, $link);
    return TRUE;
}
//Кнопки для пролистывания
//$table - таблица, к которой делается запрос;
//$num - количество выводимых страниц;
function getPageButtons($table,$num, $id) {
    global $link;
    @$page = $_GET['page'];
    if(empty($page) or $page < 0) $page = 1;
    $result_gpb = mysql_query("SELECT COUNT(*) FROM $table", $link);
    $fetch_gpb = mysql_fetch_array($result_gpb);
    $posts = $fetch_gpb[0];
    $total = (($posts - 1) / $num) + 1;
    $total = intval($total);
    if (empty($page) || $page < 0) $page = 1;
    if ($page > $total) $page = $total;
    if ($page != 1) $pervpage = '<a href=?id='.$id.'&page=1>Первая</a> | <a href=?id='.$id.'&page='. ($page - 1) .'>Предыдущая</a> | ';
    if ($page != $total) $nextpage = ' | <a href=?id='.$id.'&page='. ($page + 1) .'>Следующая</a> | <a href=?id='.$id.'&page=' .$total. '>Последняя</a>';
    if ($page - 5 > 0) $page5left = ' <a href=?id='.$id.'&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
    if ($page - 4 > 0) $page4left = ' <a href=?id='.$id.'&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
    if ($page - 3 > 0) $page3left = ' <a href=?id='.$id.'&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
    if ($page - 2 > 0) $page2left = ' <a href=?id='.$id.'&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
    if ($page - 1 > 0) $page1left = '<a href=?id='.$id.'&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
    if ($page + 5 <= $total) $page5right = ' | <a href=?id='.$id.'&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
    if ($page + 4 <= $total) $page4right = ' | <a href=?id='.$id.'&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
    if ($page + 3 <= $total) $page3right = ' | <a href=?id='.$id.'&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
    if ($page + 2 <= $total) $page2right = ' | <a href=?id='.$id.'&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
    if ($page + 1 <= $total) $page1right = ' | <a href=?id='.$id.'&page='. ($page + 1) .'>'. ($page + 1) .'</a>';
    if ($total > 1)
    {
        $content.= "<div class='pstrnav'>";
        $content.=  $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
        $content.=  "</div>";
        echo $content;
    }
}
//Проверка нахождения книги в Избранном
function checkBookFav() {
    global $link;
    $query = "SELECT * FROM favourites WHERE book_id='".$_GET['id']."' && login='".$_SESSION['login']."'";
    $result = mysql_query($query, $link);
    if (mysql_num_rows($result) == 0)
    {
        return TRUE;
    } else return FALSE;
}
//Получение комментария из базы
function getComment($num, $book_id) {
    global $link;
    @$page = $_GET['page'];
    if(empty($page) or $page < 0) $page = 1;
    $start = $page * $num - $num;
    $query = "SELECT * FROM book_comments WHERE book_comments.book_id=$book_id ORDER BY id DESC LIMIT $start,$num";
    $result = mysql_query($query, $link);
    if (mysql_num_rows($result) > 0)
    {
        $fetch = mysql_fetch_array($result);
        do
        {
            print "<div>
                    Имя: ".$fetch['login']." Дата: ".$fetch['date']."
                    <p>".$fetch['content']."</p>
                   </div>";
        } 
        while ($fetch = mysql_fetch_array($result));       
    } else print "Пока здесь нет отзывов, но Вы можете быть первым";
}
//Отправка комментария в базу
function inputComment($login, $date, $content, $book_id, $table) {
    global $link;
    $query = "INSERT INTO $table (login, content, date, book_id) VALUES ('$login', '$content', '$date', '$book_id')";
    $result = mysql_query($query, $link);
    return TRUE;
}
//
function setBirthdate() {
    global $miny,$maxy,$y,$date;
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
//Проверка даты рождения
function checkBirthDate($birthdate) {
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
?>
