<?php
/**
 * Избранные книги
 * 
 * Класс для управления избранными книгами
 * 
 * @package FavBook
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class FavBook {
    private $filename;
    private $xml;
    private $string;
    private $book;
    private $options;
    private $data = array('stat'=>FALSE);
    private $gettn;
    private $dom;
    private $id;
    private $print;
    private $length;
    private $i;
    private $result;
    /**
     * Открывает xml-файл и создаёт объект SimpleXMLElement
     * 
     * @param string Имя файла(без расширения)
     * @param array Дополнительный массив опций
     * @param string Путь к файлу(без указания имени файла)
     */
    function __construct($name, $options = array(), $filepath = 'xml/fav/') {
        $this->filename = $filepath . $name . '.xml';
        $this->xml = @simplexml_load_file($this->filename);
        $this->options = $options;
    }
    /**
     * Добавление книги в Избранное
     * 
     */
    public function addFav() {
        if ($this->xml === FALSE) {
            $this->string = '<?xml version="1.0" encoding="windows-1251" standalone="yes"?>';
            $this->string .= '<books></books>';
            $this->xml = simplexml_load_string($this->string);
        }
        $this->book = $this->xml->addChild('book');
        $this->book->addAttribute('name', $this->options['id']);
        $this->book->addChild('title', $this->options['title']);
        $this->book->addChild('author', $this->options['author']);
        $this->book->addChild('img', $this->options['img']);
        if (!@scandir('xml/fav')) { mkdir('xml/fav', 0777, TRUE); }
        if ($this->xml->asXML($this->filename)) { $this->data['stat'] = TRUE; }
    }
    /**
     * Удаление книги из Избранного
     */
    public function delFav() {
        $this->dom = new DOMDocument();
        $this->dom->load($this->filename);
        $this->xml = $this->dom->documentElement;
        $this->gettn = $this->xml->getElementsByTagName('book');
        foreach ($this->gettn as $value) {
            if ($value->getAttribute('name') == $this->options['id']) {
                $this->xml->removeChild($value);
            }
        }
        if ($this->gettn->length != 0) {
            if ($this->dom->save($this->filename)) { $this->data['stat'] = TRUE; }
        } else {
            $this->data['stat'] = TRUE;
            unlink($this->filename);
        }
    }
    /**
     * Проверка на нахождение книги в Избранном
     * 
     * @return boolean
     */
    public function checkFav() {
        if (!$this->xml) { return FALSE; }
        foreach ($this->xml->book as $value) {
            $this->id = $value->attributes();
            if ($this->id['name'] == $_GET['id']) { return TRUE; }
        }
    }
    /**
     * Вывод Избранных книг и проверка на наличие в БД. Если книга отсутствукт в БД,
     * то она удаляется из списка избранных
     * 
     * @param MDB2 Объект с коннектом к БД
     * @param string $table Таблица, где будет происходить проверка
     * @param string $field Имя поля, по которому будет проверяться
     */
    public function showFav($mdb2, $table, $field) {
        $this->print = '<h3 style="text-align: center">Увы, у Вас нет Избранных книг :-(</h3>';
        if (!$this->xml) {
            echo $this->print;
        } else {
            $this->length = $this->xml->count();
            $this->book = $this->xml->book;
            $this->i = $this->length - 1;
            for ($this->length; $this->length>0; $this->length--) {
                $this->id = $this->book[$this->i]->attributes();
                if ($this->checkBookDB($mdb2, 'SELECT * FROM '.$table.' WHERE '.$field.'='.$this->id) == 0) {
                    $this->options['id'] = $this->id;
                    $this->delFav ();
                } else {
                    echo "<div class='book'>
                    <a href='page.php?id=".  $this->id."'><img src='uploads/".  $this->book[$this->i]->img.'.jpeg'."' alt='картинка'>
                    <h1>".  $this->book[$this->i]->author."</h1>
                    <h3>".  $this->book[$this->i]->title."</h3></a>
                    <form action='fav-book-del.php' method='post'>
                        <input type='hidden' value='".  $this->id."' name='id'>
                        <input type='submit' value='Удалить из Избранного'>
                    </form>
                    </div>";
                    $this->i--;
                }
            }
        }
    }
    /**
     * Проверка Избранной книги в БД
     * 
     * @param MDB2 Объект с коннектом к БД
     * @param string Запрос
     * @return int
     */
    private function checkBookDB($mdb2, $query) {
        $this->result = $mdb2->query($query);
        return $this->result->numRows();
    }
    /**
     * Функция получения значений переменных, хранящихся в массиве 'data'
     * 
     * @param string $name
     * @return boolean
     */
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else { return FALSE; }
    }
}