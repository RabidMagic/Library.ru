<header>
    <div id="reg_auth">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['stat_log'] === TRUE) 
        {
            print "Вы вошли как ".$_SESSION['login'];
            print "<form action='logout.php' method='post'>
                    <input type='submit' value='Выйти'>
                   </form>";
        } else print "Вы вошли как гость";    
        ?>
        <div class="clearfix"></div>
    </div>
    <div id="logo">Библиотека</div>
    <?php include 'mainmenu.php' ?>
</header>
