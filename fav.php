<?php
$print = '<h3 style="text-align: center">Увы, у Вас нет Избранных книг :-(</h3>';
$filename = 'xml/fav/'.$_SESSION['login'].'.xml';
$xml = @simplexml_load_file($filename);
if ($xml == FALSE) {
    echo $print;
} else {
    $length = $xml->count();
    $book = $xml->book;
    $i = $length - 1;
    for ($length; $length > 0; $length--) {
        $id = $book[$i]->attributes();
        echo "<div class='book'>
            <a href='page.php?id=".$id."'><img src='uploads/".$book[$i]->img.'.jpeg'."' alt='картинка'>
            <h1>".$book[$i]->author."</h1>
            <h3>".$book[$i]->title."</h3></a>
            <form action='fav-book-del.php' method='post'>
                <input type='hidden' value='".$id."' name='book_id'>
                <input type='submit' value='Удалить'>
            </form>
           </div>";
        $i--;
    }
}
?>