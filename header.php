<header>
    <div id="reg_auth">
        <?php
        ((isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE) ? print "Вы вошли как ".$_SESSION['login'] : print "Вы вошли как гость");
        ?>
        <div class="clearfix"></div>
    </div>
    <div id="logo">Библиотека</div>
    <?php include 'mainmenu.php' ?>
</header>
