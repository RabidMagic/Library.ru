<?php
require_once 'MDB2.php';
//ini_set('display_errors', 'Off'); //выключение отображение ошибок
$dsn = 'mysql://user:d8YAEwatyCB7JNB2@library.ru/library';
$mdb2 = MDB2::connect($dsn);
if (PEAR::isError($mdb2))
{
    die($mdb2->getMessage());
} else {
    $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
}
?>