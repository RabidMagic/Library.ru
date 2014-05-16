<?php
session_start();
require_once 'func.php';
if (flushSession() == TRUE)
{
    if (isset($_POST['logout-acc'])) header ("Location: index.php");
    header("Location: ".$_SERVER['HTTP_REFERER']);
}