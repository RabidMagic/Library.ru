<?php
session_start();
$filename = 'xml/fav/'.$_SESSION['login'].'.xml';
$dom = new DOMDocument();
$dom->load($filename);
$xml = $dom->documentElement;
$gettn = $xml->getElementsByTagName('book');
foreach ($gettn as $value) {
    if ($value->getAttribute('name') == $_POST['book_id']) {
        $xml->removeChild($value);
    }
}
if ($gettn->length != 0) {
    $dom->save($filename);
} else    unlink($filename);
header("Location: ".$_SERVER['HTTP_REFERER']);
?>