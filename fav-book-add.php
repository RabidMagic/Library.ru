<?php
session_start();
$xml = @simplexml_load_file('xml/fav/'.$_SESSION['login'].'.xml');
if ($xml == FALSE) {
    $string = '<?xml version="1.0" encoding="windows-1251" standalone="yes"?>
                <books>
                </books>';
    $xml = simplexml_load_string($string);
}
$book = $xml->addChild('book');
$book->addAttribute('name', $_POST['book_id']);
$book->addChild('title', $_POST['book_name']);
$book->addChild('author', $_POST['book_author']);
$book->addChild('img', $_POST['book_img']);
$xml->asXML('xml/fav/'.$_SESSION['login'].'.xml');
header('Location: page.php?id='.$_POST['book_id']);
