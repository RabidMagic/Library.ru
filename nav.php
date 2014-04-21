<div class="catalog-span">
    <nav id="navmenu">
        <h1>Жанры</h1>
            <ul>
                <?php
                include 'connect.php';
                $result = mysql_query("SELECT * FROM genres ORDER BY genre ASC");
                if (mysql_num_rows($result) > 0)
                {
                    $fetch = mysql_fetch_array($result);
                    $genre = $fetch['genre'];
                    $genre = mysql_real_escape_string($genre);
                    do
                    {
                        echo "<a href='catalog.php?genre=".$fetch['genre']."'><li>".$fetch['genre']."</li></a>";
                    }
                    while ($fetch = mysql_fetch_array($result));
                } else die("Ошибка");
                ?>
            </ul>
    </nav>
</div>