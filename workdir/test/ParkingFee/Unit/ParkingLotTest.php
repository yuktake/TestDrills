<?php

use App\ParkingFee\Domain\ParkingLot;
use App\ParkingFee\Enum\ParkingLotStatus;
use PHPUnit\Framework\TestCase;

class ParkingLotTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     */
    public function 出庫するとステータスを支払い済みにする() {
        $parkingLot = new ParkingLot(
            null,
            'A1',
            ParkingLotStatus::PARKING,
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 09:00:00'),
            null,
        );
        $parkingLot->isOut(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00'));

        $this->assertEquals(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00'), $parkingLot->getOutAt());
        $this->assertEquals(ParkingLotStatus::PAID, $parkingLot->getParkingLotStatus());
    }
}