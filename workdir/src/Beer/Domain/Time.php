<?php
namespace App\Beer\Domain;

class Time {

    private \DateTimeImmutable $time;

    public function __construct(
        String $time,
    ) {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').$time);
        if ($dateTime == false) {
            throw new \Exception('フォーマットが正しくありません');
        }

        $this->time = $dateTime;
    }

    public function getValue(): \DateTimeImmutable {
        return $this->time;
    }
}