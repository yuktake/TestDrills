<?php
namespace App\ParkingFee\Domain\ParkingTicket;

use App\ParkingFee\Domain\ParkingTicket\ParkingTicketInterface;

class PurchaseMoreThanTwoThousandTicket implements ParkingTicketInterface {

    public function getMinutes(): int {
        return 60;
    }
}