<form action="adminpanel_scr.php" method="post">
    <table>
        <?php
        if (!empty($_SESSION['messages']))
        {
            displayErr($_SESSION['messages']);
            unset($_SESSION['messages']);
        }
        ?>
        <tr><th colspan="3">Изменение группы пользователей </th></tr>
        <tr>
            <td>Выберите пользователя: </td>
            <td>
                <?php
                $query = "SELECT login FROM users";
                $users = new OutputSelect($query, $mdb2);
                $users->getOption('user');
                ?>
            </td>
            <td>Выберите группу: </td>
            <td>
                <?php
                $query = "SELECT us_group FROM groups";
                $groups = new OutputSelect($query, $mdb2);
                $groups->getOption('group');
                ?>
            </td>
        </tr>
        <tr>
            <td>Подтвердите изменения</td>
            <td><input type="checkbox" name="check1"></td>
        </tr>
    </table>
    <button type="submit">Сохранить</button>
</form>
