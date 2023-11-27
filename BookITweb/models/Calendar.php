<?php

namespace app\models
{
	use app\models\calendar\calendarDay;
	/**
	 * Calendar short summary.
	 *
	 * Calendar description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
	 */
	class Calendar
	{
		/** @var $days calendarDay[] */
		public array $days = [];

		public string $month = '';
		public string $year = '';
		public string $monthName = '';
		public string $monthNameShort = '';
		public int $daysInMonth = 0;


		public function __construct($month, $year)
        {
            $this->month = $month;
            $this->year = $year;
            $this->monthName = date('F', mktime(0, 0, 0, $this->month, 1, $this->year));
            $this->monthNameShort = date('M', mktime(0, 0, 0, $this->month, 1, $this->year));
            $this->daysInMonth = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
            $this->days = $this->getDays();
        }

        private function getDays()
        {
            $days = [];
            $firstDay = date('N', mktime(0, 0, 0, $this->month, 1, $this->year));
            $lastDay = date('N', mktime(0, 0, 0, $this->month, $this->daysInMonth, $this->year));
            $daysInMonth = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
            $dayCounter = 1;
            $weekday = 1;
            $day = 1;
            $month = 1;
            $year = 1;
            $date = '';
            $dayObj = new calendarDay();
            for($i = 1; $i <= 42; $i++)
            {
                if($i < $firstDay || $i > ($daysInMonth + $firstDay - 1))
                {
                    $dayObj = new calendarDay();
                    $dayObj->weekday = '';
                    $dayObj->date = '';
                    $days[] = $dayObj;
                }
                else
                {
                    $dayObj = new calendarDay();
                    $dayObj->weekday = $weekday;
                    $dayObj->date = $day;
                    $days[] = $dayObj;
                    $day++;
                }
                $weekday++;
                if($weekday > 7)
                {
                    $weekday = 1;
                }
            }
            return $days;
        }
	}
}