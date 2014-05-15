<?php
session_start();
require_once 'func.php';
if (flushSession() == TRUE)
{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}