<?php
/**
 * Created by PhpStorm.
 * User: rporter
 * Date: 28/10/2020
 * Time: 16:42
 */

namespace App\Http\Controllers;

use Carbon\Carbon;

class DateController extends Controller
{
    /**
     * @var Carbon
     */
    public $date;

    /**
     * @var Carbon Instance
     */
    public $month;

    /**
     * @var array
     */
    public $months = [];

    /**
     * @var array
     */
    public $csv = ['headers' => [
            'Period',
            'Basic Payment',
            'Bonus Period'
        ]
    ];

    /**
     * @var int
     */
    public $bonus_date = 10;

    /**
     * construct - Set date and months properties to be used in array generation
     *
     * DateController constructor.
     */
    public function __construct()
    {
        $this->date = Carbon::now();
        for ($i = 0; $i <= 11; $i++) {
            $this->months[] = $this->date->format('m');
            $this->date->addMonths(1);
        }
    }

    /**
     * buildPaymentDatesArray - Generate array to be converted into CSV
     *
     * @throws \Exception
     */
    public function buildPaymentDatesArray()
    {
        foreach($this->months as $month) {
            $this->setMonthInstance($month);
            $this->csv[] = [
                $this->month->format('M/y'),
                ($this->getBasicPaymentDayForMonth())->format('Y-m-d'),
                ($this->getBonusPaymentDayForMonth())->format('Y-m-d')
            ];
        }
        (new CsvController())->arrayToCsv($this->csv, 'payment-dates');
    }

    /**
     * setMonthInstance - assign month property as Carbon instance for the given month
     *
     * @param int $month
     * @throws \Exception
     */
    public function setMonthInstance(int $month) {
        $this->month = (new Carbon())->months($month);
    }

    /**
     * getBasicPaymentDayForMonth - Get last weekday of the  month
     *
     * @return mixed
     */
    protected function getBasicPaymentDayForMonth()
    {
        $last_of_month = $this->month->lastOfMonth();
        return ($last_of_month->isWeekend()) ?
            $last_of_month->previousWeekday() : $last_of_month;
    }

    /**
     * getBonusPaymenDayForMonth - get first weekday on or after the bonus payment date
     *
     * @return mixed
     */
    protected function getBonusPaymentDayForMonth()
    {
        $tenth_of_month = $this->month->days($this->bonus_date);
        return ($tenth_of_month->isWeekend()) ?
            $tenth_of_month->nextWeekday() : $tenth_of_month;
    }
}