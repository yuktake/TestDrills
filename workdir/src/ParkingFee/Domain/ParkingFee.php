<?php
namespace App\ParkingFee\Domain;

use App\ParkingFee\Domain\ParkingTicket\ParkingTicketInterface;

class ParkingFee {

    private int $parkingTime;

    public function __construct(
        int $parkingTime,
    ) {
        $this->parkingTime = $parkingTime;
    }

    public function getParkingTime():int {
        return $this->parkingTime;
    }

    public function useTicket(ParkingTicketInterface $parkingTicket):void {
        $this->parkingTime -= $parkingTicket->getMinutes();
    }

    public function useMembershipCard():void {
        $this->parkingTime -= 60;
    }

    public function isFree():bool {
        return $this->parkingTime <= 0;
    }
}