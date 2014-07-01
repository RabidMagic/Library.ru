<?php
class FavBook {
    protected $filename;
    protected $xml;
    protected $string;
    protected $book;
    protected $options;
    protected $stat = FALSE;
    protected $gettn;
    protected $dom;
    protected $id;
    protected $print;
    protected $length;
    protected $i;
    protected $result;
            function __construct($name, $options = array(), $filepath = 'xml/fav/') {
                $this->filename = $filepath . $name . '.xml';
                $this->xml = @simplexml_load_file($this->filename);
                $this->options = $options;
            }
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
            public function checkFav() {
                if ($this->xml === FALSE) return;
                foreach ($this->xml->book as $value) {
                    $this->id = $value->attributes();
                    if ($this->id['name'] == $_GET['id']) {
                        $this->stat = TRUE;
                        return;
                    }
                }
            }
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
            public function getStat() {
                return $this->stat;
            }
            private function checkBookDB($mdb2, $query) {
                $this->result = $mdb2->query($query);
                return $this->result->numRows();
            }

}