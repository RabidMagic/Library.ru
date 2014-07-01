<?php
class FavBook {
    protected $filename;
    protected $xml;
    protected $string;
    protected $book;
    protected $case;
    protected $options;
    protected $stat = FALSE;
    protected $gettn;
    protected $dom;
            function __construct($case, $options, $filepath = 'xml/fav/') {
                $this->filename = $filepath . $_SESSION['login'] . '.xml';
                $this->xml = @simplexml_load_file($this->filename);
                if (is_array($options)) {
                    $this->case = $case;
                    $this->options = $options;
                } else $this->case = NULL;
                switch ($this->case) {
                    case 'add':
                        $this->addFav();
                        break;
                    case 'del':
                        $this->delFav();
                        break;
                    case 'check':
                        $this->checkFav();
                        break;
                    default:
                        echo 'Ошибка в аргументе FavBook';
                        break;
                }
            }
            private function addFav() {
                if ($this->xml == FALSE) {
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
            private function delFav() {
                $this->dom = new DOMDocument();
                $this->dom->load($this->filename);
                $this->xml = dom_import_simplexml($this->xml);
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
            private function checkFav() {

            }
            public function getStat() {
                return $this->stat;
            }

}