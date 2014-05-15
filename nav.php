<div class="catalog-span">
    <nav id="navmenu">
        <h1>Жанры</h1>
            <ul>
                <?php
                require_once 'connect.php';
                $result = $mdb2->query("SELECT * FROM genres ORDER BY genre ASC");
                if ($result->numRows() > 0)
                {
                    while ($row = $result->fetchRow())
                    {
                        print "<a href='catalog.php?genre=".$row['genre']."'><li>".$row['genre']."</li></a>";
                    }
                } else die("Ошибка");
                ?>
            </ul>
    </nav>
</div>