<?php
//Вывод новостей
class ShowNews {
    private $result;
    private $query;
    public function __construct($query, $mdb2, $min_limit=0, $max_limit=3) {
        $this->query = $query . " LIMIT $min_limit, $max_limit";
        $this->result = $mdb2->query($this->query);
    }
    public function ShowNews() { //вывод новостей сайта
        if ($this->result->numRows() > 0)
        {
            while ($this->row = $this->result->fetchRow())
            {
                print "<div class='news'>
                                <h1>".  $this->row['header']."</h1>
                                <p>".  $this->row['desc']."</p>
                           </div>";
            }
        } else print "<h3>Пока новостей нет</h3>";
    }
    public function ShowBooks() { //вывод новых книг
        if ($this->result->numRows() > 0)
        {
            while ($this->row = $this->result->fetchRow())
            {
                print "<div class='newble'>
                            <a href='page.php?id=".  $this->row['id']."'><img src='uploads/".  $this->row['img'].'.jpeg'."' alt='картинка'>
                            <div class='description'>
                                <h1>".  $this->row['book_name']."</h1>
                                <h3>".  $this->row['author']."</h3>
                            </div>
                            <div class='clearfix'></div></a>
                        </div>";
            }
        } else print "<h3>Новых книг пока нет</h3>";
    }
}