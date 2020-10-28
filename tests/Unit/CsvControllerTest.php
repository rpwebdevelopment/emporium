<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\CsvController;

class CsvControllerTest extends TestCase
{
    /**
     * testDateControllerConstructor - ensure constructor generates necessary properties
     *
     * @return void
     */
    public function testCsvControllerFilenameValidation()
    {
        $csv_controller = new CsvController();
        $this->assertSame('test-filename.csv', $csv_controller->formatCsvFilename('TestFilename'));
        $this->assertSame('test-filename.csv', $csv_controller->formatCsvFilename('Test Filename'));
        $this->assertSame('test-filename.csv', $csv_controller->formatCsvFilename('test-filename.csv'));
    }
}
