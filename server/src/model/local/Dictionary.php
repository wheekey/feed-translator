<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 19.04.18
 * Time: 11:34
 */

namespace kymbrik\src\model\local;

use kymbrik\src\model\Model;

class Dictionary implements Model
{
    public $id;
    public $language;
    public $fileName;

    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) {
                $this->id = $data['id'];
            }
            if (isset($data['fileName'])) {
                $this->fileName = $data['fileName'];
            }
            if (isset($data['language'])) {
                $this->language = $data['language'];
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
}