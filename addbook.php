<?php
//include_once '';
?>
<form action='' method='post'>
    Название книги:<input type='text' name='book'><br>
    Автор:<input type='text' name='author'><br>
    Краткое описание:<textarea name='desc'></textarea><br>
    Выберите жанр:<select name='genre'>
                    <option>Классика</option>
                    <option>Фантастика</option>
                    <option>Фэнтези</option>
                  </select>
    <hr>
    <input type='submit' value='Отправить'>
    <input type='reset' value='Сбросить'>            
</form>
