<?php
namespace App\Calendar\Repository;

class HolidayRepository {

    public function isHoliday(\DateTimeImmutable $dateTime): bool {
        $url = "https://holidays-jp.github.io/api/v1/date.json";

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);

        $response  = curl_exec($ch);
        $holidays = json_decode($response);
        if (isset($holidays->{$dateTime->format('Y-m-d')})) {
            return true;
        }

        return false;
    }
}