<?php
/**
 * Избранные книги
 * 
 * Класс для управления избранными книгами
 * 
 * @package LibraryClasses
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class FavBook {
    private $filename;
    private $xml;
    private $string;
    private $book;
    private $options;
    private $stat = FALSE;
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
            if (@scandir('xml/fav') == FALSE) mkdir('xml/fav');
            if ($this->xml->asXML($this->filename)) $this->stat = TRUE;
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
                if ($this->dom->save($this->filename) != FALSE) $this->stat = TRUE;
            } else {
                $this->stat = TRUE;
                unlink($this->filename);
            }
        }
        /**
         * Проверка на нахождение книги в Избранном
         * 
         * @return boolean
         */
        public function checkFav() {
            if ($this->xml === FALSE) return FALSE;
            foreach ($this->xml->book as $value) {
                $this->id = $value->attributes();
                if ($this->id['name'] == $_GET['id']) {
                    return TRUE;
                }
            }
        }
        /**
         * Вывод Избранных книг
         * 
         * @param MDB2 Объект с коннектом к БД
         */
        public function showFav($mdb2) {
            $this->print = '<h3 style="text-align: center">Увы, у Вас нет Избранных книг :-(</h3>';
            if ($this->xml === FALSE) {
                echo $this->print;
            } else {
                $this->length = $this->xml->count();
                $this->book = $this->xml->book;
                $this->i = $this->length - 1;
                for ($this->length; $this->length>0; $this->length--) {
                    $this->id = $this->book[$this->i]->attributes();
                    if ($this->checkBookDB($mdb2, 'SELECT * FROM upload_books WHERE id='.$this->id) == 0) {
                        $this->options['id'] = $this->id;
                        $this->delFav ();
                    } else {
                        echo "<div class='book'>
                        <a href='page.php?id=".  $this->id."'><img src='uploads/".  $this->book[$this->i]->img.'.jpeg'."' alt='картинка'>
                        <h1>".  $this->book[$this->i]->author."</h1>
                        <h3>".  $this->book[$this->i]->title."</h3></a>
                        <form action='fav-book-del.php' method='post'>
                            <input type='hidden' value='".  $this->id."' name='book_id'>
                            <input type='submit' value='Удалить из Избранного'>
                        </form>
                        </div>";
                        $this->i--;
                    }
                }
            }
        }
        /**
         * Возврат переменной stat
         * 
         * @return boolean
         */
        public function getStat() {
            return $this->stat;
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

}