<?php
//В будущем, это будет отдельная страница, а пока только инклюд.
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['submit']))
{
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
    if (empty($messages))
    {
        mb_internal_encoding("UTF-8");
        $_POST['author-sname'] = securityCheck($_POST['author-sname']);
        $_POST['author-fname'] = securityCheck($_POST['author-fname']);
        $sname = $_POST['author-sname'];
        $sname = strval($sname);
        $sname = mb_ucfirst($sname);
        $fname = $_POST['author-fname'];
        $fname = strval($fname);
        $fname = mb_ucfirst($fname);
        $array = array($sname, $fname);
        $author = implode(" ", $array);     
        $book = $_POST['book'];
        $book = securityCheck($book);
        $book = mb_ucfirst($book);
        $desc = $_POST['desc'];
        $desc = securityCheck($desc);
        $desc = strval($desc);
        $desc = mb_ucfirst($desc);
        $genre = $_POST['genre'];
        $query = "SELECT * FROM upload_books WHERE book_name = '$book' && author = '$author' && genre = '$genre'";
        $result = mysql_query($query, $link);
        $rows = mysql_num_rows($result);
        if ($rows === 0)
        {    
            if (uploadFile('img', 'image/jpeg', 2097152, "uploads/") === TRUE)
            {
                $login = $_SESSION['login'];
                $book = mysql_real_escape_string($book);
                $book = trim($book);
                $book = htmlspecialchars($book);
                $author = mysql_real_escape_string($author);
                $author = trim($author);
                $author = htmlspecialchars($author);
                $desc = mysql_real_escape_string($desc);
                $desc = trim($desc);
                $desc = htmlspecialchars($desc);
                $date = date("d - m - Y");
                $query = "INSERT INTO upload_books SET book_name = '$book', author = '$author', description = '$desc', genre = '$genre', login = '$login', date = '$date', img = '$uploadfile'";
                $result = mysql_query($query, $link);
                $messages[] = "Книга была успешно добавлена";
                //header("Location: account.php");
            } else $messages[] = "Не удалось загрузить файл";
        } else $messages[] = "Такая книга уже есть";
    }
    
}

?>
<form action='' method='post' enctype="multipart/form-data">
    <table>
        <?php
        if (!empty($messages))
        {
            displayErr($messages);
        }
        ?>
        <tr>
            <td>Название книги: </td>
            <td><input type="text" name="book"></td>
        </tr>
        <tr>
            <td>Автор:</td>
            <td><input type="text" placeholder="Имя" name="author-fname"><input type="text" placeholder="Фамилия" name="author-sname"></td>
        </tr>
        <tr>
            <td>Краткое описание: </td>
            <td><textarea name="desc"></textarea></td>
        </tr>
        <tr>
            <td>Выберите жанр: </td>
            <td>
                <select name="genre">
                    <option selected>Выберите жанр</option>
                    <?php
                    outputGenres();
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Выберите файл для загрузки(.jpg): </td>
            <td><input type="file" name="img"></td>
        </tr>
    </table>
    <input type='submit' value='Отправить' name="submit">
    <input type='reset' value='Сбросить'>            
</form>
