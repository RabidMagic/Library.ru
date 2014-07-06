<form id="Book" action='addbook_scr.php' method='post' enctype="multipart/form-data">
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
                <?php
                $query = "SELECT genre FROM genres";
                $genres = new OutputSelect($query, $mdb2);
                $addinset = '<option disabled selected>Выберите жанр</option>';
                $genres->getOption('genre', $addinset);
                ?>  
            </td>
        </tr>
        <tr>
            <td>Выберите файл обложки для загрузки(.jpg/.png): </td>
            <td><input type="file" name="img"></td>
        </tr>
        <tr>
            <td>Выберите .txt файл: </td>
            <td><input type="file" name="txt"></td>
        </tr>
    </table>
    <input type='submit' value='Отправить'>
    <input type='reset' value='Сбросить'>            
</form>
