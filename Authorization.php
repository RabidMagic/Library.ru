<?php
/**
 * Регистрация/авторизация на сайте
 *
 * @package LibraryClasses
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class Authorization {
    private $query;
    private $result;
    private $mdb2;
    private $fields;
    /**
     * Создание объекта и присвоение значений параметров членам класса,
     * проверка $fields на тип array
     * 
     * @param MDB2 Объект коннекта к БД
     * @param array Массив опций, где ключи - имена полей в БД, а значения - их значения
     * @return boolean
     */
    public function __construct($mdb2, $fields) {
            $this->mdb2 = $mdb2;
            $this->fields = $fields;
            if (!is_array($this->fields)) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    /**
     * Занесение пользователя в БД. В случае успеха возвращает TRUE, 
     * в случае неудачи - FALSE
     * 
     * @param string Имя таблицы, куда заносятся данные
     * @return boolean
     */
    public function setUser($table) {
        $this->query = 'INSERT INTO '.$table.' (';
        foreach ($this->fields as $key => $value) {
            $this->query .= $key.', ';
        }
        $this->query .= ') VALUES (';
        foreach ($this->fields as $key => $value) {
            $this->query .= "'$value'".', ';
        }
        $this->query .= ')';
        $this->query = str_replace(', )', ')', $this->query);
        $this->result = $this->mdb2->exec($this->query);
        if (boolval($this->result) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Сброс данных сессии, процесс логаута
     * 
     * @return boolean
     */
    static public function flushSession() {
        session_unset(); 
        session_destroy();
        return TRUE;
    }
    /**
     * Установка данных в сессию, процесс логина
     * 
     * @param string Логин пользователя
     * @param string Группа пользователя
     */
    static public function setSession($login, $group) {
        $_SESSION['login'] = $login;
        $_SESSION['us_group'] = $group;
        $_SESSION['stat_log'] = TRUE;
    }
    /**
     * Получение данных пользователя из БД.
     * В случае удачи - TRUE, нет - FALSE
     * 
     * @param array Массив, содержащий в ключах поля таблицы, в значениях - их значении
     * @param string Имя таблицы БД
     * @return boolean
     */
    public function getUser($login_f, $table) {
        if (!is_array($login_f)) {
            return FALSE;
        }
        $this->query = 'SELECT * FROM '.$table.' WHERE ';
        foreach ($login_f as $key => $value) {
            $this->query .= $key.'='."'$value'";
            $this->query .= ' && ';
        }
        $this->query = substr_replace($this->query, NULL, -4);
        $this->result = $this->mdb2->query($this->query);
        if ($this->result->numRows() == 1) {
            return $this->result->fetchRow();
        } else {
            return FALSE;
        }
    }
}
