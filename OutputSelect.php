<?php
//Вывод с тегами select;
class OutputSelect {
    private $row;
    private $result;
    private $value;
    private $case;
    public function __construct($query, $mdb2, $case) {
        $this->result = $mdb2->query($query);
        switch ($case) {
            case 'genres':
                $this->outputGenres();
                break;
            case 'users':
                $this->outputUsers();
                break;
            case 'groups';
                $this->outputGroups();
                break;
            default:
                print "Ошибка! Неверно указан оператор";
                break;
        }
    }
    private function outputGenres() { //Вывод жанров
        if ($this->result->numRows() > 0)
        {
            print '<select name="genre">';
            print '<option selected>Выберите жанр</option>';
            while ($this->row = $this->result->fetchRow())
            {
                foreach ($this->row as $this->value)
                {
                    print "<option>$this->value</option>\n";
                }
            }
            print '</select>';
        }
    }
    private function outputUsers() {  //Вывод списка пользователей
        if ($this->result->numRows() > 0)
        {
            print '<select name=\'user\'>';
            while ($this->row = $this->result->fetchRow())
            {
                foreach ($this->row as $this->value)
                {
                    print "<option>$this->value</option>\n";
                }
            }
            print '</select>';
        } else "Ошибка! Не найден ни один пользователь";
    }
    private function outputGroups() { //Вывод списка групп пользователей
        if ($this->result->numRows() > 0)
        {
            print '<select name=\'group\'>';
            while ($this->row = $this->result->fetchRow())
            {
                foreach ($this->row as $this->value)
                {
                    print "<option>$this->value</option>\n";
                }
            }
            print '</select>';
        } else "Ошибка! Не найдены группы";
    }
}