<form action='addbook_scr.php' method='post' enctype="multipart/form-data">
    <table>
        <?php
        if (!empty($_SESSION['messages']))
        {
            displayErr($_SESSION['messages']);
            unset($_SESSION['messages']);
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
    <input type='submit' value='Отправить'>
    <input type='reset' value='Сбросить'>            
</form>
