<div id="topmenu">
    <a href="index.php"><div class="button" id="link1" style="margin: -20px 0 0 0">Главная</div></a>
    <a href="catalog.php"><div class="button" id="link2" style="margin: -20px 0 0 115px;">Каталог</div></a>
    <a href='guestbook.php'><div class="button" id="link3" style="margin: -20px 0 0 230px;">Оставить отзыв</div></a>
                <?php if (!empty($_SESSION['stat_log'])) { print "<a href='account.php'><div class='button' style='margin: -20px 0 0 345px;'>Личный кабинет</div></a>"; } ?>
</div>
