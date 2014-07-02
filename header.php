<header>
    <div id="reg_auth">
        <?php
        unset($_SESSION['count']);
        if (isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE) 
        {
            print "Вы вошли как ".$_SESSION['login']."<br>";
            print "<a href='logout.php'><button>Выйти</button></a>";
        } else print "Вы вошли как гость<br>
                     <button id='button_login'><a href='auth.php'>Войти</a></button>
                     <button id='button_reg'><a href='registration.php'>Регистрация</a></button>";
        ?>
        <div class="clearfix"></div>
    </div>
    <?php require_once 'mainmenu.php' ?>
    <div id="logo">Библиотека</div>
    <form class="header-search" action="results.php" method="get">
        <input type="search" name="search" placeholder="Поиск">
    </form>    
</header>
