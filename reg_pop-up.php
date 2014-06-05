        <div id="reg_pop-up">
            <div>
                <div onclick="popDown();">X</div>
                <form action='reg_scr.php' method='post'>
                    <h1>Регистрация</h1>
                    <table>
                        <tr>
                            <td>Ваш логин:</td>
                            <td><input type='text' id="login" name='login' size='16' maxlength='16' onchange="loginCheck('login');"></td>
                            <td id="login_message"></td>
                        </tr>
                        <tr>
                            <td>Ваш пароль:</td>
                            <td><input type='password' id="password" name='password' size='16' maxlength='16' onchange="loginCheck('password');"></td>
                            <td id="password_message"></td>
                        </tr>
                        <tr>
                            <td>Повторите пароль:</td>
                            <td><input type='password' id="password2" name='password2' size='16' maxlength='16' onchange="loginCheck('password2');"></td>
                            <td id="password2_message"></td>
                        </tr>
                        <tr>
                            <td>Ваша дата рождения:</td>
                            <td><?php setBirthdate(); ?></td>
                        </tr>
                        <tr>
                            <td>Ваш пол:</td>
                            <td><input type='radio' name='gender' value='Мужской'>Мужской<br><input type='radio' name='gender' value='Женский'>Женский</td>
                        </tr>
                        <tr>
                            <td>Ваш e-mail:</td>
                            <td><input type='text' id="email" name='email' onchange="loginCheck('email');"></td>
                            <td id="email_message"></td>
                        </tr>
                        <tr>
                            <td>Вы робот?</td>
                            <td><input type='radio' name='checkbot' value='yes' checked>Да<br><input type='radio' name='checkbot' value='no'>Нет</td>
                        </tr>
                    </table>
                    <input type='submit' value='Зарегистрироваться' name='reg'>
                </form>
            </div>
        </div>