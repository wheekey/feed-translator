<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 12:39
 */

namespace kymbrik\src\utility;

use kymbrik\src\entity\DictionaryFile;
use kymbrik\src\entity\FeedFile;

class XMLTranslator implements Translator
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
        /*$cnt = 0;
        $sedCommand = "sed '";
        foreach ($this->dictionary->asArray() as $word => $translate) {
            $cnt++;

            $w = trim($word);
            $tr = trim($translate);
            $sedCommand .= "s@'\"$w\"'@'\"$tr\"'@g;";
            if($cnt == 10)
            {
                break;
            }
        }

        file_put_contents("test.txt", $sedCommand . "' {$this->feed->getFilePath()} > {$this->feed->getResultFilePath()}");
        echo $sedCommand . "' {$this->feed->getFilePath()} > {$this->feed->getResultFilePath()}";
        echo passthru($sedCommand . "' {$this->feed->getFilePath()} > {$this->feed->getResultFilePath()}");*/

        $sedCommandMultiple = "cp {$this->feed->getResultFilePath()}.tmp {$this->feed->getResultFilePath()} && cat {$this->feed->getResultFilePath()} | parallel -k --pipe 'sed \"";
        $cnt = 0;
        foreach ($this->dictionary->asArray() as $word => $translate) {
            $w = trim($word);
            $tr = trim($translate);
            if ($cnt == 0) {
                //Это скопирует исходный файл в новое место. Потом будем его же только и менять, который скопировали.
                $sedCommand = "sed 's@'\"$w\"'@'\"$tr\"'@g' {$this->feed->getFilePath()} > {$this->feed->getResultFilePath()}.tmp";
                passthru($sedCommand);
            }
            $cnt++;

            //тут мы делаем так, чтобы замен делать за раз 100 штук
            $sedCommandMultiple .= "s@'\"$w\"'@'\"$tr\"'@g;";
            if (strlen($sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp ") > 78000) {
                //echo $sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp";

                //file_put_contents("test.txt", $sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp ");
                passthru($sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp ");
                $sedCommandMultiple = "cp {$this->feed->getResultFilePath()}.tmp {$this->feed->getResultFilePath()} && cat {$this->feed->getResultFilePath()} | parallel -k --pipe 'sed \"";

            }

            //echo $cnt . PHP_EOL;
        }

        //То, что осталось допереводить (т.е. остаток, что не равен %100)
        //echo $sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp && cp {$this->feed->getResultFilePath()}.tmp {$this->feed->getResultFilePath()}" . PHP_EOL;
        passthru($sedCommandMultiple . "\"' > {$this->feed->getResultFilePath()}.tmp && cp {$this->feed->getResultFilePath()}.tmp {$this->feed->getResultFilePath()}");
    }
}