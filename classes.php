<?php
//Кнопки пролистывания
class PageButtons {
    private $content;
    private $page;
    private $result;
    private $posts;
    private $total;
    private $pageleft = array();
    private $pageright = array();
    private $pervpage;
    private $nextpage;
    public function __construct($num, $query, $mdb2) {
        $this->page = $_GET['page'];
        $this->result = $mdb2->query($query);
        $this->posts = $this->result->numRows();
        $this->total = (($this->posts - 1) / $num) + 1;
        $this->total = intval($this->total);
        if (empty($this->page) || $this->page < 0) $this->page = 1;
        if ($this->page > $this->total) $this->page = $this->total;
    }
    public function getGBPageButtons() { //Страница guestbook.php
        if ($this->page != 1) $this->pervpage = '<a href=?page=1>Первая</a> | <a href=?page='. ($this->page - 1) .'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?page='. ($this->page + 1) .'>Следующая</a> | <a href=?page=' .$this->total. '>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 5) .'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 4) .'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        $this->setPageButtons();
    }
    public function getBookPageButtons() { //Страница page.php
        if ($this->page != 1) $this->pervpage = '<a href=?id='.$_GET['id'].'&page=1>Первая</a> | <a href=?id='.$_GET['id'].'&page='. ($this->page - 1) .'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 1) .'>Следующая</a> | <a href=?id='.$_GET['id'].'&page=' .$this->total. '>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?id='.$_GET['id'].'&page='. ($this->page - 5) .'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?id='.$_GET['id'].'&page='. ($this->page - 4) .'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?id='.$_GET['id'].'&page='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?id='.$_GET['id'].'&page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?id='.$_GET['id'].'&page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        $this->setPageButtons();
    }
    public function getSearchPageButtons() { //Страница results.php
        if ($this->page != 1) $this->pervpage = '<a href=?search='.$_GET['search'].'&page=1>Первая</a> | <a href=?search='.$_GET['search'].'&page='. ($this->page - 1) .'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 1) .'>Следующая</a> | <a href=?search='.$_GET['search'].'&page=' .$this->total. '>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?search='.$_GET['search'].'&page='. ($this->page - 5) .'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?search='.$_GET['search'].'&page='. ($this->page - 4) .'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?search='.$_GET['search'].'&page='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?search='.$_GET['search'].'&page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?search='.$_GET['search'].'&page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        $this->setPageButtons();
    }
    public function getCatalogPageButtons() {
        if ($this->page != 1) $this->pervpage = '<a href=?genre='.$_GET['genre'].'&page=1>Первая</a> | <a href=?genre='.$_GET['genre'].'&page='. ($this->page - 1) .'>Предыдущая</a> | ';
        if ($this->page != $this->total) $this->nextpage = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 1) .'>Следующая</a> | <a href=?genre='.$_GET['genre'].'&page=' .$this->total. '>Последняя</a>';
        if ($this->page - 5 > 0) $this->pageleft[] = ' <a href=?genre='.$_GET['genre'].'&page='. ($this->page - 5) .'>'. ($this->page - 5) .'</a> | ';
        if ($this->page - 4 > 0) $this->pageleft[] = ' <a href=?genre='.$_GET['genre'].'&page='. ($this->page - 4) .'>'. ($this->page - 4) .'</a> | ';
        if ($this->page - 3 > 0) $this->pageleft[] = ' <a href=?genre='.$_GET['genre'].'&page='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
        if ($this->page - 2 > 0) $this->pageleft[] = ' <a href=?genre='.$_GET['genre'].'&page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        if ($this->page - 1 > 0) $this->pageleft[] = '<a href=?genre='.$_GET['genre'].'&page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?genre='.$_GET['genre'].'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
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
//Вывод результатов запросов на экран
class GetResults {
    private $page;
    private $start;
    private $result;
    private $row;
    private $query;
    public function __construct($num, $query, $mdb2) {
        $this->page = $_GET['page'];
        if(empty($this->page) or $this->page < 0) $this->page = 1;
        $this->start = $this->page * $num - $num;
        $this->query = $query . " LIMIT $this->start, $num";
        $this->result = $mdb2->query($this->query);
    }
    public function getReview() { //страницы page.php и guestbook.php
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
    public function getSearchResults() { //страница results.php
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
                            <a href='page.php?id=".  $this->row['id']."'><img src='uploads/".  $this->row['img']."' alt='картинка'>
                            <div class='description'>
                                <h1>".  $this->row['book_name']."</h1>
                                <h3>".  $this->row['author']."</h3>
                            </div>
                            <div class='clearfix'></div></a>
                        </div>";
            }
        } else print "<h3 style='text-align: center'>Новых книг пока нет</h3>";
    }
}
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