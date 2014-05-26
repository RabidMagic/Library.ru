<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
//Блок изменение группы пользователя;
if (!empty($_POST['check1']))
{
  $mdb2->exec("UPDATE users SET us_group = '".$_POST['group']."' WHERE login = '".$_POST['user']."'");
  $_SESSION['us_group'] = $_POST['group'];
  $messages[] = "Информация о группе успешно обновлена";
}
$_SESSION['messages'] = $messages;
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
//Следующий блок;