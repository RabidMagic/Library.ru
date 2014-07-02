<?php
//Вывод с тегами select;
class OutputSelect {
    private $row;
    private $result;
    private $value;
    private $inset;
    private $print;
    public function __construct($query, $mdb2) {
        $this->result = $mdb2->query($query);
    }
    public function getOption($inset, $addinset = NULL) {
        $this->inset = $inset;
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