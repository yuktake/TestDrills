<?php
namespace App\Beer\Domain;

class MonthStart {

    private int $year;

    private int $month;

    public function __construct(
        int $year,
        int $month,
    ) {
        $this->year = $year;
        $this->month = $month;
    }

    public function getValue():\DateTimeImmutable {
        $monthStart = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->year.'-'.$this->month.'-01 00:00:00');
        if ($monthStart == false) {
            throw new \Exception();
        }

        return $monthStart;
    }
}