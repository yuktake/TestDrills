<?php
namespace App\Beer\Repository;

use App\Beer\Domain\HappyHour;
use App\Beer\Domain\Time;

class HappyHourRepository {

    public function getHappyHour(): HappyHour {
        // 本来はDBから時間帯を取得
        $startTime = new Time('16:00:00');
        $endTime = new Time('17:59:00');
        $happyHour = new HappyHour($startTime, $endTime);

        return $happyHour;
    }
}