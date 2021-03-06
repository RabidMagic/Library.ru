<?php
/**
 * Кнопки постраничной навигации
 * 
 * @package PageButtons
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class PageButtons {
    private $inset;
    private $content;
    private $page;
    private $result;
    private $posts;
    private $total;
    private $pageleft = array();
    private $pageright = array();
    private $pervpage;
    private $nextpage;
    /**
     * Отправка запроса на выборку и высчитывание количества страниц
     * 
     * @param int Количество выводимых блоков
     * @param string Запрос
     * @param MDB2 Объект коннекта к БД
     * @param array|NULL Допольнительная часть GET-запроса
     */
    public function __construct($num, $query, $mdb2, $inset = NULL) {
        $this->page = $_GET['page'];
        $this->result = $mdb2->query($query);
        $this->posts = $this->result->numRows();
        if ($inset == NULL) { 
            $this->inset = NULL; 
        } else {
            foreach ($inset as $key => $value) {
                $this->inset .= '&'.$key.'='.$value;
            }
        }
        $this->total = (($this->posts - 1) / $num) + 1;
        $this->total = intval($this->total);
        if (empty($this->page) || $this->page < 0) $this->page = 1;
        if ($this->page > $this->total) $this->page = $this->total;
    }
    /**
     * Вывод кнопок
     */
    public function getButtons() {
        if ($this->page != 1) $this->pervpage = '<a href=?page=1'.$this->inset.'>Первая</a> | <a href=?page='. ($this->page - 1) . $this->inset.'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?page='. ($this->page + 1) . $this->inset .'>Следующая</a> | <a href=?page=' .$this->total . $this->inset.'>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 5) . $this->inset.'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 4) . $this->inset.'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 3) . $this->inset.'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 2) . $this->inset.'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?page='. ($this->page - 1) . $this->inset.'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 1) . $this->inset.'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 2) . $this->inset.'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 3) . $this->inset.'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 4) . $this->inset.'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 5) . $this->inset.'>'. ($this->page + 5) .'</a>';
        $this->setPageButtons();
    }
    /**
     * Получение кнопок
     */
    private function setPageButtons() {
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
