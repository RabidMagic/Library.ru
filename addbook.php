<?php
//В будущем, это будет отдельная страница, а пока только инклюд.
session_start();
include_once 'func.php';
include_once 'connect.php';
if (isset($_POST['submit']))
{
    $messages = array();
    if (empty($_POST['book']))
    {
        $messages[] = "Вы не указали название книги";
    }
    if (empty($_POST['author']))
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
        $book = $_POST['book'];
        $author = $_POST['author'];
        $desc = $_POST['desc'];
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
                $author = mysql_real_escape_string($author);
                $desc = mysql_real_escape_string($desc);
                $date = date("d - m - Y");
                $query = "INSERT INTO upload_books SET book_name = '$book', author = '$author', description = '$desc', genre = '$genre', login = '$login', date = '$date', img = '$uploadfile'";
                $result = mysql_query($query, $link);
                $messages[] = "Книга была успешно добавлена";
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
            <td><input type="text" name="author"></td>
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