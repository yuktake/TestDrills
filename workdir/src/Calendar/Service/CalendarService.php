<?php
namespace App\Calendar\Service;

use App\Calendar\Domain\Date;
use App\Calendar\Repository\HolidayRepository;

class CalendarService {

    private $holidayRepository;

    public function __construct(
        HolidayRepository $holidayRepository,
    ) {
        $this->holidayRepository = $holidayRepository;
    }

    public function getDateColor(\DateTimeImmutable $dateTime):string {
        $isHoliday = $this->holidayRepository->isHoliday($dateTime);
        $date = new Date($dateTime, $isHoliday);

        return $date->getColor();
    }
}