<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
switch ($_POST["check"]){
    case "login" :
        field_validator("'Логин'", $_POST["login"], "alphanumeric", 4, 32);
        if (empty($messages)) {
            if (!checkName($_POST['login']))
                {
                    $messages[] = 'Логин занят.';
                } else 
                {
                    $messages[] = 1;
                }}
        break;
    case "password" :
        field_validator("'Пароль'", $_POST["password"], "string", 4, 16);
        if (empty($messages)){
            $messages[] = 1;
        }
        break;
    case "password2" :
        field_validator("'Подтверждение пароля'", $_POST["password2"], "string", 4, 16);
        if (empty($messages)) {
            if (strcmp($_POST['password'], $_POST['password2']))
            {
                $messages[] = "Ваши пароли не совпадают";
            } else {
                $messages[] = 1;
            }
        }    
        break;
    case "email" :
        field_validator("e-mail", $_POST['email'], "email");
        if (empty($messages)) {
            if ($_POST['email'] !== "") {
                $result = $mdb2->query("SELECT email FROM users WHERE email = '".$_POST['email']."'");
                if ($result->numRows() != 0) {
                    $messages[] = "Этот e-mail уже занят";
                } else 
                {
                    $messages[]  = 1;
                }
            }
        }    
        break;
    case "birth" :
        if (!empty($_POST['reg-b-month']) && !empty($_POST['reg-b-day']) && !empty($_POST['reg-b-year']))
        {
            if (!checkdate($_POST['reg-b-month'], $_POST['reg-b-day'], $_POST['reg-b-year']))
            {
                $messages[] = "Введена некорректная дата";
            } else  {$messages[] = 1;}
        } else {$messages[] = "Вы не ввели дату рождения";
        } 
        break;
}

foreach ($messages as $value) {
    echo $value;
}
unset($messages);