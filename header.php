<header>
    <div id="reg_auth">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE) 
        {
            print "Вы вошли как ".$_SESSION['login'];
            print "<a href='logout.php'><button>Выйти</button></a>";
        } else print "Вы вошли как гость
                   <a href='auth.php'><button>Войти</button></a>";
        ?>
        <div class="clearfix"></div>
    </div>
    <div id="logo">Библиотека</div>
    <?php include 'mainmenu.php' ?>
</header>
