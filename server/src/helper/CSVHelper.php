<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 16.03.18
 * Time: 18:00
 */

namespace kymbrik\src\helper;


class CSVHelper
{
    public static function array2csv(array &$array)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }

    /**
     * @param $arrResult
     * @param string $filename
     * @param array|null $headers Заголовки - обычный одномерный массив
     * @return string
     */
    public static function downloadCSVFile($arrResult, $filename = "reestr.csv", array $headers = null)
    {
        // output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename={$filename}");

        // create a file pointer connected to the output stream
        $fp = fopen('php://output', 'w');
        fputcsv($fp, array_keys(reset($arrResult)));
        if (!empty($headers)) {
            fputcsv($fp, $headers);
        }

        foreach ($arrResult as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
}