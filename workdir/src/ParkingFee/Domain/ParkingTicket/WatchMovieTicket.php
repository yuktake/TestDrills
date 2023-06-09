<?php
namespace App\ParkingFee\Domain\ParkingTicket;

use App\ParkingFee\Domain\ParkingTicket\ParkingTicketInterface;

class WatchMovieTicket implements ParkingTicketInterface {

    public function getMinutes(): int {
        return 180;
    }
}