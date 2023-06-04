<?php
namespace App\Calendar\Domain;

class Date {

    private \DateTimeImmutable $dateTime;

    private bool $isHoliday;

    public function __construct(
        \DateTimeImmutable $dateTime,
        bool $isHoliday,
    ) {
        $this->dateTime = $dateTime;
        $this->isHoliday = $isHoliday;
    }

    public function getColor():string {
        if($this->isHoliday || $this->dateTime->format('w') === '0') {
            return 'red';
        }

        if($this->dateTime->format('w') === '6') {
            return 'blue';
        } else {
            return "black";
        }
        
    }
}