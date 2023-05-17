<?php
namespace App\Beer\Domain;

class MonthEnd {

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
        $monthStart = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->year.'-'.$this->month.'-01 23:59:59');
        if ($monthStart == false) {
            throw new \Exception();
        }
        $monthEnd = $monthStart->modify('last day of this month');

        return $monthEnd;
    }
}