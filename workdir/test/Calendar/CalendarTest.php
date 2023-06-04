<?php

use App\Calendar\Repository\HolidayRepository;
use App\Calendar\Service\CalendarService;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     */
    public function 平日は黒色で表示する() {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', '2023-06-05');
        $holidayRepository = new HolidayRepository();
        $calendarService = new CalendarService($holidayRepository);
        $dateColor = $calendarService->getDateColor($dateTime);

        $this->assertEquals('black', $dateColor);
    }

    /**
     * @test
     */
    public function 土曜日は青色で表示する() {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', '2023-06-03');
        $holidayRepository = new HolidayRepository();
        $calendarService = new CalendarService($holidayRepository);
        $dateColor = $calendarService->getDateColor($dateTime);

        $this->assertEquals('blue', $dateColor);
    }

    /**
     * @test
     */
    public function 日曜日は赤色で表示する() {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', '2023-06-04');
        $holidayRepository = new HolidayRepository();
        $calendarService = new CalendarService($holidayRepository);
        $dateColor = $calendarService->getDateColor($dateTime);

        $this->assertEquals('red', $dateColor);
    }

    /**
     * @test
     * @dataProvider 祝日であれば平日と土曜日も赤色で表示する用データ
     */
    public function 祝日であれば平日と土曜日も赤色で表示する(
        \DateTimeImmutable $dateTime,
    ) {
        $holidayRepository = new HolidayRepository();
        $calendarService = new CalendarService($holidayRepository);
        $dateColor = $calendarService->getDateColor($dateTime);

        $this->assertEquals('red', $dateColor);
    }

    public static function 祝日であれば平日と土曜日も赤色で表示する用データ() {
        return [
            '平日かつ祝日' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-05-03'),
            ],
            '土曜日かつ祝日' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-04-29'),
            ],
        ];
    }
}