<?php
/**
 * Created by PhpStorm.
 * User: rporter
 * Date: 28/10/2020
 * Time: 17:56
 */

namespace App\Http\Controllers;

use League\Csv\Writer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CsvController extends Controller
{
    /**
     * arrayToCsv - store passed array as CSV to CSV Storage drive
     *
     * @param array $array
     * @param string $filename
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function arrayToCsv(array $array, string $filename)
    {
        $filename = $this->formatCsvFilename($filename);

        Storage::disk('csv')->put($filename, '');
        $content = Storage::disk('csv')->get($filename);

        try {
            $writer = Writer::createFromString($content, 'w');
            $writer->insertAll($array);
        } catch (CannotInsertRecord $e) {
            echo "Unable to store CSV";
        }

        $content = $writer->getContent();
        if (Storage::disk('csv')->put($filename, $content)) {
            echo 'File saved successfully to /storage/app/csv/' . $filename;
        }
    }

    /**
     * formatCsvFilename - Format given filename to ensure it is valid
     *
     * @param string $filename
     * @return string
     */
    public function formatCsvFilename(string $filename)
    {
        return Str::kebab(
            (Str::endsWith($filename, ['.csv', '.CSV'])) ?
                $filename : $filename . '.csv'
        );
    }
}