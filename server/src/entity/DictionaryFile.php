<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 12:57
 */

namespace kymbrik\src\entity;

class DictionaryFile extends File
{
    /**
     * @var Language
     */
    private $language;

    public function __construct(string $fileName, FileType $fileType, FileExtension $fileExtension, Language $language)
    {
        parent::__construct($fileName, $fileType, $fileExtension);
        $this->language = $language;
        $this->formFilePath();
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function formFilePath()
    {
        if (FileExtension::EMPTY == $this->getFileExtension()) {
            $this->setFilePath(getenv("APP_DIR") . getenv("FILES_DIR") . "/" . $this->getFileType() . "/" . $this->getLanguage() . "/" . $this->getFileName());
        } else {
            $this->setFilePath(getenv("APP_DIR") . getenv("FILES_DIR") . "/" . $this->getFileType() . "/" . $this->getLanguage() . "/" . $this->getFileName() . "." . $this->getFileExtension());
        }
    }

    public function asArray(bool $assoc = true): array
    {
        $assocArr = [];
        $simpleArr = array_map('str_getcsv', file($this->getFilePath()));
        if (!$assoc) {
            return $simpleArr;
        }

        foreach ($simpleArr as $row) {
            $assocArr[$row[0]] = $row[1];
        }
        $keys = array_map('strlen', array_keys($assocArr));
        array_multisort($keys, SORT_DESC, $assocArr);

        return $assocArr;
    }

}