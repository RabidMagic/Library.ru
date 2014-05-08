<div id="topmenu">
                <a href="index.php"><div class="button">Главная</div></a>
                <a href="catalog.php"><div class="button">Каталог</div></a>
                <a href='guestbook.php'><div class="button">Оставить отзыв</div></a>
                <?php if (!empty($_SESSION['stat_log'])) { print "<a href='account.php'><div class='button'>Личный кабинет</div></a>"; } ?>
</div>
