<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Symfony\Component\Console\Input\Input;

class JanuaryMatrixController extends Controller
{
    public function rearrangeDaysOfWeek($startOfWeek)
    {
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $startOfWeekIndex = array_search($startOfWeek, $daysOfWeek);

        return array_merge(
            array_slice($daysOfWeek, $startOfWeekIndex),
            array_slice($daysOfWeek, 0, $startOfWeekIndex)
        );
    }

    public function generateCalendarImage(Request $r)
    {
        $baseImage = Image::make(public_path('images/template.jpg'))->resize(1000, 800);

        $currentYear = $r->Input('year');
        $currentMonth = $r->Input('month');
        $monthStart = Carbon::create($currentYear, $currentMonth, 1); // all data about the first date

        $selectedStartDay = $r->Input('start_of_week');
        // $selectedStartDay='Mon';
        $monthEnd = $monthStart->copy()->endOfMonth(); //give only the end date of the month
        $daysOfWeek = $this->rearrangeDaysOfWeek($selectedStartDay);
        $firstDay = $monthStart->dayOfWeek; // gives first day of the week

        if ($selectedStartDay == "Sun") {
            $firstDay = $firstDay + 1;

            // $firstDayOfMonth = $firstDay -1;
        } elseif ($selectedStartDay == "Sat") {
            $firstDay = $firstDay + 2;
        }

        $startX = (array_search($selectedStartDay, $daysOfWeek) * 90) + 50;
        $startY = 350;

        $baseImage->text($monthStart->format('F Y'), $startX, $startY, function ($font) {
            $font->file(public_path('images/e.ttf'));
            $font->size(20);
            $font->color('#000000');
        });

        $startX = 50;
        $startY = 380;

        foreach ($daysOfWeek as $dayOfWeek) {
            $baseImage->text($dayOfWeek, $startX, $startY, function ($font) {
                $font->file(public_path('images/e.ttf'));
                $font->size(20);
                $font->color('#000000');
            });
            $startX += 90; //spacing between the days........................................///
        }

        $startX = 50;
        $startY += 40;

        $birthdayDates = ['2026-11-10', '2026-11-16', '2026-11-11'];
        $holidayDates = [

            "diwali" => "2026-11-05",
            "om" => "2026-11-15",
            "eid" => "2026-11-20"
        ];

        $emptySpaces = ($firstDay + 6) % 7; // Add space at empty cell
        for ($i = 0; $i < $emptySpaces; $i++) {
            $baseImage->text('', $startX, $startY, function ($font) {
                $font->file(public_path('images/e.ttf'));
                $font->size(20);
                $font->color('#000000');
            });
            $startX += 90;
        }



        // Loop through the days of the month
        for ($day = 1; $day <= $monthEnd->day; $day++) {
            $dateToCheck = $monthStart->copy()->day($day)->toDateString();
            $isHoliday = in_array($dateToCheck, $holidayDates);
            $isBirthday = in_array($dateToCheck, $birthdayDates);

            if ($isHoliday) {
                $holidayName = strtolower(str_replace(' ', '', array_search($dateToCheck, $holidayDates)));
                $hicon = public_path('images/' . $holidayName . '.png'); //hicon is holiday icon
                $svgPath = Image::make($hicon)->resize(40, 40);
                $iconX = $startX + 23;
                $iconY = $startY - 30;
                $baseImage->insert($svgPath, 'top-left', $iconX, $iconY);
            }

            if ($isBirthday) {
                $bicon = public_path('images/birthday.png');
                $birthdayIcon = Image::make($bicon)->resize(40, 40);
                $iconX = $startX + 30;
                $iconY = $startY - 30;
                $baseImage->insert($birthdayIcon, 'top-left', $iconX, $iconY);
            }


           //displaying all day
            $baseImage->text($day, $startX, $startY, function ($font) {
                $font->file(public_path('images/e.ttf'));
                $font->size(24);
                $font->color('#000000');
            });
            $startX += 90;

            // If the next day is Sunday, move to the next row
            if (($emptySpaces + $day) % 7 == 0) {
                $startX = 50;
                $startY += 70; // Adjust the Y position for the next row
            }
        }

        $imagePath = public_path('images/generated_calendar.jpg');
        $baseImage->save($imagePath);

        return view('generatedimage', ['imagePath' => $imagePath]);
    }
}