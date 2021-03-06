<?php 

namespace ReaderFile;

use ReaderFile\Reader;

class ReadCSV extends Reader
{
    /**
     * Constructor of class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Reads the content of CSV file and storages
     * in an array so then returns.
     * 
     * The array format is: array[row][header] => collumn
     * 
     * @throws ErrorException if don't found the file => "failed to open stream: No such file or directory"
     * 
     * @param filepath path of file to read
     * @return content array of values
     */
    public static function readFile($filepath, $delimiter=';') {
        $content = [];
        $header = [];
        $headerCount = 0;
        $row = 0;
        if (($handle = fopen($filepath, "r")) !== false) {
            while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                $num = count($data);
                if ($row === 0) {
                    $headerCount = $num;
                    for ($c=0; $c < $headerCount; $c++) {
                        $header[$c] = $data[$c] ?? "campo_desconhecido_{$c}";
                    }
                } else {
                    $line = [];
                    for ($c=0; $c < $headerCount; $c++) {
                        $line[$header[$c]] = $data[$c] ?? '';
                    }
                    array_push($content, $line);
                }
                $row++;
            }
        }
        fclose($handle);

        return $content;
    }
}
