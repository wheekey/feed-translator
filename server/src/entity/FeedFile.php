<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 13:07
 */

namespace kymbrik\src\entity;

class FeedFile extends File
{
    private $resultFilePath;

    public function __construct(string $fileName, FileType $fileType, FileExtension $fileExtension)
    {
        parent::__construct($fileName, $fileType, $fileExtension);
        $this->formFilePath();
        $this->formResultFilePath();
    }

    public function formFilePath()
    {
        $this->setFilePath(getenv("APP_DIR") . getenv("FILES_DIR") . "/" . $this->getFileType() . "/" . $this->getFileExtension() . "/" . $this->getFileName() . "." . $this->getFileExtension());
    }

    public function formResultFilePath()
    {
        $this->setResultFilePath(getenv("APP_DIR") . getenv("FILES_DIR") . "/translate/" . $this->getFileExtension() . "/" . $this->getFileName() . "." . $this->getFileExtension());
    }

    /**
     * @return mixed
     */
    public function getResultFilePath()
    {
        return $this->resultFilePath;
    }

    /**
     * @param mixed $resultFilePath
     */
    public function setResultFilePath($resultFilePath)
    {
        $this->resultFilePath = $resultFilePath;
    }


}