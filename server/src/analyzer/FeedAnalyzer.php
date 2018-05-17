<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 17.05.18
 * Time: 14:01
 */

namespace kymbrik\src\analyzer;


use kymbrik\src\entity\FeedFile;

class FeedAnalyzer implements FileAnalyzer
{

    private $feedFile;

    /**
     * FeedAnalyzer constructor.
     */
    public function __construct(FeedFile $feedFile)
    {
        $this->feedFile = $feedFile;
    }

    public function isExistRussianSymbols(): bool
    {
        return preg_match("/.*[а-яА-Я].*/xuis", $this->feedFile->getResultFilePath());
    }

    public function analyze()
    {
        // TODO: Implement analyze() method.
    }
}