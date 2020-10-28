<?php

namespace Tests\Feature;

use App\Http\Controllers\DateController;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvGenerationTestTest extends TestCase
{
    /**
     * testFileGeneration - Test files generated
     * 
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function testFileGeneration()
    {
        $date_controller = new DateController();
        Storage::disk('csv')->delete($date_controller->filename);
        
        $date_controller->buildPaymentDatesArray();
        $this->assertSame(13, count($date_controller->csv));

        $date_controller->generateCsv();
        $exists = Storage::disk('csv')->exists($date_controller->filename);
        $this->assertTrue($exists);

    }
}
