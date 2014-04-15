<header>
    <div id="reg_auth">
        <?php
        if (isset($_SESSION['login']) && isset($_SESSION['id'])) 
        {
            echo "Вы вошли как ".$_SESSION['login']."<br>";
            echo "<form action='exit.php' method='post'>";
            echo "<input type='hidden' name='exit' value='true'>";
            echo "<input type='submit' value='Выход'>";
            echo "</form>";
        } else {
        echo "<form action='auth.php' method='post'>";
            echo "<input type='hidden' name='posted' value='true'>";
            echo "<input type='text' name='login' size='15' maxlength='15' placeholder='Ваш логин'><br>";
            echo "<input type='password' name='password' size='15' maxlength='15' placeholder='Ваш пароль'><br>";
            echo "<a href='forgot.php'>Забыли?</a>";
            echo "<input type='submit' value='Войти'><br>";
            echo "<a href='registration.php'>Регистрация</a><br>";
        echo "</form>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
    <div id="logo">Библиотека</div>
    <?php include 'mainmenu.php' ?>
</header>
