<header>
    <div id="reg_auth">
        <?php
        unset($_SESSION['count']);
        if (isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE) 
        {
            print "Вы вошли как ".$_SESSION['login'];
            print "<a href='logout.php'><button>Выйти</button></a>";
        } else print "Вы вошли как гость
                   <a href='auth.php'><button>Войти</button></a>
                   <a href='registration.php'><button>Регистрация</button></a>";
        ?>
        <div class="clearfix"></div>
    </div>
    <div id="logo">Библиотека</div>
    <form class="header-search" action="results.php" method="get">
        <input type="search" name="search" placeholder="Поиск">
        <button type="submit">Найти</button>
    </form>    
    <?php require_once 'mainmenu.php' ?>
</header>
