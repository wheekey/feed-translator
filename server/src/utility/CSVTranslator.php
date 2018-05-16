<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 17:05
 */

namespace kymbrik\src\utility;

use kymbrik\src\entity\DictionaryFile;
use kymbrik\src\entity\FeedFile;

class CSVTranslator implements Translator
{
    private $dictionary;
    private $feed;

    public function __construct(DictionaryFile $dictionary, FeedFile $feed)
    {
        $this->dictionary = $dictionary;
        $this->feed = $feed;
    }

    public function translate()
    {

    }
}