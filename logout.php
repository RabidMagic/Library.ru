<?php
session_start();
include_once 'func.php';
if (clearSess() == TRUE)
{
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
}