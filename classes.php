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
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
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
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?id='.$_GET['id'].'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
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
        if ($this->page + 5 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 5) .'>'. ($this->page + 5) .'</a>';
        if ($this->page + 4 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 4) .'>'. ($this->page + 4) .'</a>';
        if ($this->page + 3 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
        if ($this->page + 2 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
        if ($this->page + 1 <= $this->total) $this->pageright[] = ' | <a href=?search='.$_GET['search'].'&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        $this->setPageButtons();
    }
    private function setPageButtons() { //Формирования вывода кнопок
        if ($this->total > 1)
        {
            $this->content = "<div class='pstrnav'>";
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
        }
    }
}
//Вывод результатов запросов на экран
class GetResults {
    private $page;
    private $start;
    private $num;
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
                print "<div>
                        Имя: ".  $this->row['login']." Дата: ".  $this->row['date']."
                        <p>".  $this->row['content']."</p>
                       </div>";
            } 
               
        } else print "Пока здесь нет отзывов, но Вы можете быть первым";
    }
    public function getSearchResults() { //страница results.php
        if ($this->result->numRows() > 0)
        {
            while ($this->row = $this->result->fetchRow())
            {
                print "<div>
                        ".$this->row['author'].$this->row['book_name'].$this->row['desc']."
                       </div>";
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
        } else print "<h3>Новых книг пока нет</h3>";
    }
}
////Регистрация - авторизация( для работы нужен func.php)
//class Authentication {
//    static function CheckLogedIn() {
//        if (empty($_SESSION['stat_log']))
//        {
//            header("Location: auth.php");
//        }
//    }
//    static function SetSession($login, $password) {
//        $_SESSION['login'] = $login;
//        $_SESSION['password'] = $password;
//        $_SESSION['stat_log'] = TRUE;
//        return TRUE;
//    }
//    static function FlushSession() {
//        unset($_SESSION['login']);
//        unset($_SESSION['password']);
//        unset($_SESSION['stat_log']);
//        session_destroy();
//        return TRUE;
//    }
//}