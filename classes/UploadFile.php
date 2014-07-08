<?php
/**
 * Загрузка файлов с обеспечением безопасности
 *
 * @package UploadFile
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class UploadFile {
    protected $uploaddir;
    protected $uploadfile;
    protected $fp;
    protected $mdb2;
    protected $result;
    public function __construct($uploaddir, $uploadfile, $mdb2 = NULL) {
        $this->uploaddir = $uploaddir;
        $this->uploadfile = $uploadfile;
        $this->mdb2 = $mdb2;
    }
    /**
     * Перенос файлов в указанную директорию и, если надо, добавление
     * записи в БД
     * 
     * @param Resource $img Ресурс картинки, созданный методом UploadIMG::setFile 
     * @param Array $txt Массив текста, созданный методом UploadTXT::setFile
     * @param string|null $query Запрос на добавление в БД
     * @return boolean
     */
    public function addFiles($img, $txt, $query = NULL) {
        if (is_array($txt) && is_resource($img)) {
            if (@!scandir($this->uploaddir)) { mkdir ($this->uploaddir); }
            imagejpeg($img, $this->uploaddir.$this->uploadfile.'.jpeg');
            $this->fp = fopen($this->uploaddir.$this->uploadfile.'.txt', 'a');
            foreach ($txt as $value) {
                fwrite($this->fp, $value);
            }
            fclose($this->fp);
            if (is_object($this->mdb2) && is_string($query)) {
                $this->result = $this->mdb2->exec($query);
                if (is_int($this->result)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
/**
 * Создание и возврат текста из загруженного файла
 * 
 * @package UploadFile
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class UploadTXT extends Upload {
    protected $txt = array();
    /**
     * Создание массива текста из загруженного файла
     * 
     * @param string $name Имя поля загрузки
     * @return boolean
     */
    public function setFile($name) {
        if ($_FILES[$name]['size'] > static::MAX_SIZE) {
            $this->messages = 'Недопустимый размер файла текста';
            return FALSE;
        }
        $this->mime = explode('/', $_FILES[$name]['type']);
        if ($this->mime[1] != 'plain') {
            $this->messages = 'Неверный тип файла текста';
            return FALSE;
        }
        $this->fp = fopen($_FILES[$name]['tmp_name'], 'r');
        while (!feof($this->fp)) {
            $this->txt[] = fgetss($this->fp);
        }
        fclose($this->fp);
        return $this->txt;
    }
    /**
     * Возвращение ошибок
     * 
     * @return string
     */
    public function getErrors() {
        return $this->messages;
    }
}
/**
 * Создание новой картинки из загруженного файла
 * 
 * @package UploadFile
 * @author tervaskanto <frolkinnikita94@gmail.com>
 */
class UploadIMG extends Upload {
    protected $img;
    protected $size;
    const WIDTH = 250;
    const HEIGHT = 385;
    /**
     * Создание новой картинки из загруженного файла
     * 
     * @param string $name Имя поля загрузки
     * @return boolean
     */
    public function setFile($name) {
        if ($_FILES[$name]['size'] > static::MAX_SIZE) {
            $this->messages = 'Недопустимый размер файла картинки';
            return FALSE;
        }
        $this->mime = explode('/', $_FILES[$name]['type']);
        switch ($this->mime[1]) {
            case 'png':
                $this->fp = imagecreatefrompng($_FILES[$name]['tmp_name']);
                break;
            case 'jpeg':
                $this->fp = imagecreatefromjpeg($_FILES[$name]['tmp_name']);
                break;
            default :
                $this->messages = 'Неверный тип файла картинки';
                return FALSE;
        }
        $this->img = imagecreatetruecolor(static::WIDTH, static::HEIGHT);
        $this->size = getimagesize($_FILES[$name]['tmp_name']);
        imagecopyresampled($this->img, $this->fp, 0, 0, 0, 0, static::WIDTH, static::HEIGHT, $this->size[0], $this->size[1]);
        unset($this->fp);
        return $this->img;
    }
    /**
     * Возвращение ошибок
     * 
     * @return string
     */
    public function getErrors() {
        return $this->messages;
    }
}
abstract class Upload {
    protected $messages;
    protected $mime;
    protected $fp;
    const MAX_SIZE = 3000000;
    public abstract function setFile($name);
    public abstract function getErrors();
}