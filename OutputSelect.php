<?php
/**
 * Вывод тегов 'select'
 * 
 * @package LibraryClasses
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class OutputSelect {
    private $row;
    private $result;
    private $value;
    private $inset;
        /**
         * Отправка запроса на выборку
         * 
         * @param string Запрос
         * @param MDB2 Объект коннекта к БД
         */
        public function __construct($query, $mdb2) {
            $this->result = $mdb2->query($query);
        }
        /**
         * 
         * @param string Значение аттрибута 'name'
         * @param string Допольнительные теги 'select'
         */
        public function getOption($inset, $addinset = NULL) {
            if ($this->result->numRows() > 0)
            {
                $this->inset = '<select name=\'';
                $this->inset .= $inset;
                $this->inset .= '\'>';
                if ($addinset != NULL) $this->inset .= $addinset;
                print $this->inset;
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
}