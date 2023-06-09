<?php

use App\ParkingFee\Domain\ParkingFee;
use App\ParkingFee\Domain\ParkingLot;
use App\ParkingFee\Domain\ParkingTicket\ParkingTicketInterface;
use App\ParkingFee\Domain\ParkingTicket\PurchaseMoreThanFiveThousandTicket;
use App\ParkingFee\Domain\ParkingTicket\PurchaseMoreThanTwoThousandTicket;
use App\ParkingFee\Domain\ParkingTicket\WatchMovieTicket;
use App\ParkingFee\Enum\ParkingLotStatus;
use PHPUnit\Framework\TestCase;

class ParkingFeeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider チケットを使用すると駐車時間が一部無料になる用データ
     */
    public function チケットを使用すると駐車時間が一部無料になる(
        ParkingTicketInterface $ticket,
        int $expectedParkingTime,
    ) {
        $parkingLot = new ParkingLot(
            null,
            'A1',
            ParkingLotStatus::PARKING,
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 09:00:00'),
            null,
        );
        $parkingFee = $parkingLot->getParkingFee(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00'));
        $parkingFee->useTicket($ticket);

        $this->assertEquals($expectedParkingTime, $parkingFee->getParkingTime());
    }

    /**
     * @test
     */
    public function モストカードを持っていると駐車時間が６０分無料になる() {
        $parkingLot = new ParkingLot(
            null,
            'A1',
            ParkingLotStatus::PARKING,
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 09:00:00'),
            null,
        );
        $parkingFee = $parkingLot->getParkingFee(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00'));
        $parkingFee->useMembershipCard();

        $this->assertEquals(120, $parkingFee->getParkingTime());
    }

    /**
     * @test
     * @dataProvider 駐車時間が0分以下だと無料になる用データ
     */
    public function 駐車時間が0分以下だと無料になる(
        int $parkingTime,
        bool $expectedValue,
    ) {
        $parkingFee = new ParkingFee($parkingTime);

        $this->assertEquals($expectedValue, $parkingFee->isFree());
    }

    public static function チケットを使用すると駐車時間が一部無料になる用データ() {
        
        return [
            '２０００円以上のお買い物で駐車料金６０分無料' => [
                new PurchaseMoreThanTwoThousandTicket(),
                120,
            ],
            '５０００円以上のお買い物で駐車料金１２０分無料' => [
                new PurchaseMoreThanFiveThousandTicket(),
                60,
            ],
            '映画を見ると１８０分無料' => [
                new WatchMovieTicket(),
                0,
            ],
        ];
    }

    public static function 駐車時間が0分以下だと無料になる用データ() {
        
        return [
            '駐車時間が1分以上' => [
                1,
                false,
            ],
            '駐車時間が0分以上' => [
                0,
                true,
            ],
            '駐車時間がマイナス' => [
                -1,
                true,
            ],
        ];
    }
}