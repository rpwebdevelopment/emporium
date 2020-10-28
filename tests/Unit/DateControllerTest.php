<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\DateController;

class DateControllerTest extends TestCase
{
    /**
     * testDateControllerConstructor - ensure constructor generates necessary properties
     *
     * @return void
     */
    public function testDateControllerConstructor()
    {
        $date_controller = new DateController();
        $this->assertInstanceOf(Carbon::class, $date_controller->date);
        $this->assertIsArray($date_controller->months);
        $this->assertSame(12, count($date_controller->months));
    }

    /**
     * testDateControllerCsvGeneration - ensure method produces array of expected length
     *
     * @throws \Exception
     */
    public function testDateControllerCsvGeneration()
    {
        $date_controller = new DateController();
        $date_controller->buildPaymentDatesArray();
        $this->assertIsArray($date_controller->csv);
        $this->assertSame(13, count($date_controller->csv));
    }

    /**
     * testDateControllerSetMonthInstance - ensure method returns valid class instance
     *
     * @throws \Exception
     */
    public function testDateControllerSetMonthInstance()
    {
        $date_controller = new DateController();
        $date_controller->setMonthInstance(1);
        $this->assertInstanceOf(Carbon::class, $date_controller->month);
    }
}
