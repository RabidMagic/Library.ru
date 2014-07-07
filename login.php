<?php
require_once 'func.php';
require_once 'connect.php';
include_once 'classes/Authorization.php';
session_start();
$login = securityCheck($_POST['login']);
$password = securityCheck($_POST['password']);
$password = md5(md5($password));
field_validator("Логин", $login, "alphanumeric", 4, 32);
field_validator("Пароль", $password, "string", 4, 16);
$fields = array(
    'login'=>$login,
    'password'=>$password,
);
$auth = new Authorization($mdb2, $fields);
if ($auth) {
    $get_user = $auth->getUser($fields, 'users');
    if ($get_user) {
        Authorization::setSession($login, $get_user['us_group']);
        $referer = $_SERVER['HTTP_REFERER'];
        if (!empty($_SESSION['referer'])) { $referer = $_SESSION['referer']; }
        unset($_SESSION['referer']);
        unset($_SESSION['count']);
        if ($referer == NULL) { $referer = 'index.php'; }
        header('Location: '.$referer);
    } else {
        $messages[] = "Ошибка при подключении";
        $_SESSION['messages'] = $messages;
        header("Location: auth.php");
    }
}
