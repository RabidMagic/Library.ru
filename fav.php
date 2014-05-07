<?php
$login = $_SESSION['login'];
$query = "SELECT * FROM favourites,upload_books WHERE favourites.book_id=upload_books.id && favourites.login='$login' ORDER BY favourites.book_id DESC";
$result = mysql_query($query, $link);
if (mysql_num_rows($result) > 0)
{
    $fetch = mysql_fetch_array($result);
    do
    {
        print "<div>
                <a href='page.php?id=".$fetch['id']."'><img src='uploads/".$fetch['img']."' alt='картинка'>
                <h1>".$fetch['author']."</h1>
                <h3>".$fetch['book_name']."</h3></a>
                <form action='fav-book-del.php' method='post'>
                    <input type='hidden' value='$login' name='fav-login'>
                    <input type='hidden' value='".$fetch['id']."' name='fav-b-id'>
                    <input type='submit' name='fav-del' value='Удалить'>
                </form>
               </div>";
    } while ($fetch = mysql_fetch_array($result));
}
?>