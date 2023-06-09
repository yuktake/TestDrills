<?php
namespace App\ParkingFee\Domain;

use App\ParkingFee\Enum\ParkingLotStatus;

class ParkingLot {

    private ?int $id;

    private string $lotNumber;

    private ParkingLotStatus $status;

    private \DateTimeImmutable $parkAt;

    private ?\DateTimeImmutable $outAt;

    public function __construct(
        ?int $id,
        string $lotNumber,
        ParkingLotStatus $status,
        \DateTimeImmutable $parkAt,
        ?\DateTimeImmutable $outAt,
    ) {
        $this->id = $id;
        $this->lotNumber = $lotNumber;
        $this->status = $status;
        $this->parkAt = $parkAt;
        $this->outAt = $outAt;
    }

    public function getParkingLotStatus():ParkingLotStatus {
        return $this->status;
    }

    public function getOutAt():\DateTimeImmutable {
        return $this->outAt;
    }

    public function getParkingFee(\DateTimeImmutable $outAt):ParkingFee {
        $diff = $this->parkAt->diff($outAt);
        $hour =  intval($diff->format("%h"));
        $minutes = intval($diff->format("%i"));
        $totalMinutes = ($hour*60) + $minutes;

        return new ParkingFee($totalMinutes);
    }

    public function isOut(\DateTimeImmutable $outAt):void {
        $this->outAt = $outAt;
        $this->status = ParkingLotStatus::PAID; 
    }
}