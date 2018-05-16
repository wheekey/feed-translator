<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.04.18
 * Time: 13:32
 */

namespace kymbrik\src\entity;

use MyCLabs\Enum\Enum;

class FileExtension extends Enum
{
    const XML = "xml";
    const CSV = "csv";
    const EMPTY = "";
}