<?php
include_once 'connect.php';
$ref = $_SERVER['HTTP_REFERER'];
$id = $_POST['id'];
$name = $_POST['name'];
$genre = $_POST['genre'];
$ex = explode('?', $ref);
$ex[0] = str_replace('page', 'catalog', $ex[0]);
$ex[1] = str_replace($ex[1], 'genre='.$genre, $ex[1]);
//var_dump($ex);
unset($_POST);
$query = 'DELETE FROM upload_books WHERE id='.$id.' LIMIT 1';
$result = @$mdb2->exec($query);
if (PEAR::isError($mdb2)) {
    echo $mdb2->getMessage();
    header('Location: '.$ref);
} else {
    $txt = 'uploads/'.$name.'.txt';
    $img = 'uploads/'.$name.'.jpeg';
    if (unlink($img) && unlink($txt)) header ('Location: '.$ex[0].'?'.$ex[1]);  else header ('Location '.$ref);
}


