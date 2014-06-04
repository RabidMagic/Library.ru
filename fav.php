<?php
//$login = $_SESSION['login'];
$query = "SELECT * FROM favourites,upload_books WHERE favourites.book_id=upload_books.id && favourites.login='".$_SESSION['login']."' ORDER BY favourites.book_id DESC";
$result = $mdb2->query($query);
if ($result->numRows() > 0)
{
    while ($row = $result->fetchRow())
    {
        print "<div class='book'>
                <a href='page.php?id=".$row['id']."'><img src='uploads/".$row['img']."' alt='картинка'>
                <h1>".$row['author']."</h1>
                <h3>".$row['book_name']."</h3></a>
                <form action='fav-book-del.php' method='post'>
                    <input type='hidden' value='$login' name='fav-login'>
                    <input type='hidden' value='".$row['id']."' name='fav-b-id'>
                    <input type='submit' value='Удалить'>
                </form>
               </div>";
    }
} else print 'Увы, у Вас нет Избранных книг :-(';
?>