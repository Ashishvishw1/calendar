<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Calender extends Component
{
    public $startingDay = 'Sun';
    public $calendarMatrix = [];

    public function generateCalendar()
    {
        $month = 5; // For example, April
        $year = 2023; // For example, 2023
        
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $holidays = [1]; 

        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $selectedStartingDayIndex = array_search(4, $daysOfWeek);

        $numRows = ceil(($daysInMonth + $selectedStartingDayIndex) / 7);

        $this->calendarMatrix = [];

        for ($row = 0; $row < $numRows; $row++) {
            $calendarRow = [];
            for ($col = 0; $col < 7; $col++) {
                $dayNumber = $col + 1 + $row * 7;

                if ($dayNumber <= 0 || $dayNumber > $daysInMonth) {
                    $calendarRow[] = ''; // Empty cell for remaining days
                } else {
                    $isHoliday = in_array($dayNumber, $holidays);
                    if ($isHoliday) {
                        $calendarRow[] = 'Holiday';
                    } else {
                        $calendarRow[] = $dayNumber;
                    }
                }
            }
            $this->calendarMatrix[] = $calendarRow;
        }
    }

    public function render()
    {
        return view('livewire.calender');
    }
}
