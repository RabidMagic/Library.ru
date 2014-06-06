<?php
require_once 'func.php';
require_once 'connect.php';
session_start();
if (empty($_POST['book']))
{
    $messages[] = "Вы не указали название книги";
}
if (empty($_POST['author-fname']) && empty($_POST['author-sname']))
{
    $messages[] = "Вы не указали автора";
}
if (empty($_POST['desc']))
{
    $messages[] = "Вы не указали краткое описание";
}
if ($_POST['genre'] == "Выберите жанр")
{
    $messages[] = "Вы не выбрали жанр";
}
//field_validator("URL", $_POST['url'], "url");
if (empty($messages))
{
    mb_internal_encoding("UTF-8");
    $sname = mb_ucfirst($_POST['author-sname']);
    $fname = mb_ucfirst($_POST['author-fname']);
    $author = $fname . ' ' . $sname;
    $author = securityCheck($author);
    $book = $_POST['book'];
    $book = securityCheck($book);
    $book = mb_ucfirst($book);
    $desc = $_POST['desc'];
    $desc = securityCheck($desc);
    $desc = mb_ucfirst($desc);
    $genre = $_POST['genre'];
    $query = "SELECT * FROM upload_books WHERE book_name = '$book' && author = '$author'";
    $result = $mdb2->query($query);
    if ($result->numRows() == 0)
    {
        $max = 20;
        restart:
        $uploadfile = setRandomString(5, $max);
        //$result = $mdb2->query("SELECT img FROM uploads_books WHERE img = '$uploadfile'");
        if ($mdb2->query("SELECT img FROM uploads_books WHERE img = '$uploadfile'")->numRows() != 0)
        {
            //unset($uploadfile);
            $max++;
            goto restart;
        }
        if (uploadFile('img', $uploadfile) == FALSE)
        {
            $messages[] = "Не удалось загрузить обложку";
        } else $img = $uploadfile;
        if (!strstr($_POST['url'], "://")) $_POST['url'] = "http://" . $_POST['url'];
        if (!empty($img))
        {
            $login = $_SESSION['login'];
            $query = "INSERT INTO upload_books SET book_name = '$book', author = '$author', description = '$desc', genre = '$genre', login = '$login', img = '$img', url = '".$_POST['url']."'";
            $result = $mdb2->exec($query);
            header("Location: account.php");
        }
    } else $messages[] = "Такая книга уже есть";
}
$_SESSION['messages'] = $messages;
header("Location: account.php");
?>