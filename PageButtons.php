<?php
//Кнопки пролистывания
class PageButtons {
    private $inset;
    private $query;
    private $content;
    private $page;
    private $result;
    private $posts;
    private $total;
    private $pageleft = array();
    private $pageright = array();
    private $pervpage;
    private $nextpage;
    public function __construct($num, $query, $inset , $mdb2) {
        $this->page = $_GET['page'];
        $this->result = $mdb2->query($query);
        $this->posts = $this->result->numRows();
        $this->inset = $inset;
        $this->total = (($this->posts - 1) / $num) + 1;
        $this->total = intval($this->total);
        if (empty($this->page) || $this->page < 0) $this->page = 1;
        if ($this->page > $this->total) $this->page = $this->total;
    }
    public function getButtons() {
        if ($this->page != 1) $this->pervpage = '<a href=?'.$this->inset.'&page=1>Первая</a> | <a href=?'.$this->inset.'&page='. ($this->page - 1) .'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?'.$this->inset.'&page='. ($this->page + 1) .'>Следующая</a> | <a href=?'.$this->inset.'&page=' .$this->total. '>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?'.$this->inset.'&page='. ($this->page - 5) .'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?'.$this->inset.'&page='. ($this->page - 4) .'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?'.$this->inset.'&page='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?'.$this->inset.'&page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?'.$this->inset.'&page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?'.$this->inset.'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?'.$this->inset.'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?'.$this->inset.'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?'.$this->inset.'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?'.$this->inset.'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        $this->setPageButtons();
    }
    private function setPageButtons() { //Формирование вывода кнопок
        if ($this->total > 1)
        {
            $this->content = "<div class='pg_buttons'>";
            $this->content .= $this->pervpage;
            foreach ($this->pageleft as $value) {
                $this->content .= $value;
            }
            $this->content .= '<b>'.$this->page.'</b>';
            foreach ($this->pageright as $value) {
                $this->content .= $value;
            }
            $this->content .= $this->nextpage;
            $this->content .= "</div>";
            echo $this->content;
            $this->pageleft = array();
            $this->pageright = array();
        }
    }
}
