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

interface Translator
{
    public function translate();
}