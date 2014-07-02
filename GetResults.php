<?php
/**
 * Вывод результатов
 * 
 * @package LibraryClasses
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class GetResults {
    private $page;
    private $start;
    private $result;
    private $row;
    private $query;
    /**
     * Отправка запроса на выборку
     * 
     * @param int Количество выводимых блоков
     * @param string Запрос
     * @param MDB2 Объект коннекта к БД
     */
    public function __construct($num, $query, $mdb2) {
        $this->page = $_GET['page'];
        if(empty($this->page) or $this->page < 0) $this->page = 1;
        $this->start = $this->page * $num - $num;
        $this->query = $query . " LIMIT $this->start, $num";
        $this->result = $mdb2->query($this->query);
    }
    /**
     * Вывод комментариев
     * 
     */
    public function getReview() {
        if ($this->result->numRows() > 0)
        {
            while ($this->row = $this->result->fetchRow())
            {
                print "<div class='comment'>
                            <div class='comment_head'>
                                <div class='user'>Пользователь: <b>".  $this->row['login']."</b></div> <div class='date'>Дата: <b>".  $this->row['date']."</b></div></div>
                            <div class='comment_body'>".  $this->row['content']."</div>
                       </div>";
            } 
               
        } else print "<h3 style='text-align: center;'>Пока здесь нет отзывов, но Вы можете быть первым</h3>";
    }
    /**
     * Вывод результатов поиска
     */
    public function getSearchResults() {
        if ($this->result->numRows() > 0)
        {
            while ($this->row = $this->result->fetchRow())
            {
                print "<a href='page.php?id=".$this->row['id']."'>
                        <div id='search'>
                            <div><h1>".$this->row['author']."</h1></div>
                            <div><h3>".$this->row['book_name']."</h3></div>
                            <div>".$this->row['description']."</div>
                        </div>
                        </a>";
            }     
        }
    }
}