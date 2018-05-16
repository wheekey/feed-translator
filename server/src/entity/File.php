<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 13:07
 */

namespace kymbrik\src\entity;

abstract class File
{
    private $fileName;
    private $fileType;
    private $filePath;
    private $fileExtension;

    public function __construct(string $fileName, FileType $fileType, FileExtension $fileExtension)
    {
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->fileExtension = $fileExtension;
    }

    public function getFileSrc()
    {
        return file_get_contents($this->getFilePath());
    }

    public function uploadFile(string $url)
    {
        file_put_contents($this->getFilePath(), file_get_contents($url));
    }

    /**
     * @return FileExtension
     */
    public function getFileExtension(): FileExtension
    {
        return $this->fileExtension;
    }

    /**
     * @param FileExtension $fileExtension
     */
    public function setFileExtension(FileExtension $fileExtension)
    {
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return FileType
     */
    public function getFileType(): FileType
    {
        return $this->fileType;
    }

    /**
     * @param FileType $fileType
     */
    public function setFileType(FileType $fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

}