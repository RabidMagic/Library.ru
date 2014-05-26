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
if ($_POST['genre'] === "Выберите жанр")
{
    $messages[] = "Вы не выбрали жанр";
}
field_validator("'Ссылка'", $_POST['url'], "url");
if (empty($messages))
{
    mb_internal_encoding("UTF-8");
    $_POST['author-sname'] = securityCheck($_POST['author-sname']);
    $_POST['author-fname'] = securityCheck($_POST['author-fname']);
    $sname = $_POST['author-sname'];
    $sname = mb_ucfirst($sname);
    $fname = $_POST['author-fname'];
    $fname = mb_ucfirst($fname);
    $author_arr = array($sname, $fname);
    $author = implode(" ", $author_arr);     
    $book = $_POST['book'];
    $book = securityCheck($book);
    $book = mb_ucfirst($book);
    $desc = $_POST['desc'];
    $desc = securityCheck($desc);
    $desc = mb_ucfirst($desc);
    $genre = $_POST['genre'];
    $query = "SELECT * FROM upload_books WHERE book_name = '$book' && author = '$author' && genre = '$genre'";
    $result = $mdb2->query($query);
    if ($result->numRows() == 0)
    {
        $uploadfile = setRandomString('upload_books', 'img');
        if (uploadFile('img', 'image/jpeg', 2097152, "uploads") == FALSE)
        {
            $messages[] = "Не удалось загрузить обложку";
        } else $img = $uploadfile;
        if (!strstr($_POST['url'], "://")) $_POST['url'] = "http://" . $_POST['url'];
        if (isset($img))
        {
            $login = $_SESSION['login'];
            $query = "INSERT INTO upload_books SET book_name = '$book', author = '$author', description = '$desc', genre = '$genre', login = '$login', img = '$img', url = '".$_POST['url']."'";
            $result = $mdb2->exec($query);
            $messages[] = "Книга была успешно добавлена";
            $_SESSION['messages'] = $messages;
            header("Location: account.php");
        }
    } else $messages[] = "Такая книга уже есть";
}
$_SESSION['messages'] = $messages;
header("Location: account.php");
?>