<?php
require_once 'func.php';
include_once 'classes/Authorization.php';
session_start();
if (Authorization::flushSession() == TRUE) {
    $ref = $_SERVER['HTTP_REFERER'];
    header('Location: '.$ref);
}