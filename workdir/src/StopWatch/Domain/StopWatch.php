<?php
namespace App\StopWatch\Domain;

use App\StopWatch\Enum\Status;

class StopWatch {

    private string $time = '00:00';

    private \DateTimeImmutable $start;

    private \DateTimeImmutable $end;

    private Status $status;

    public function __construct() {
        $this->start = new \DateTimeImmutable();
        $this->end = new \DateTimeImmutable();
        $this->status = Status::PREPARE;
    }

    public function getTime():string {
        return $this->time;
    }

    public function getStatus():Status {
        return $this->status;
    }

    public function start(): void {
        $this->status = Status::MEASURE;
    }

    public function pause(\DateTimeImmutable $end): void {
        if($this->status == Status::PREPARE || $this->status == Status::PAUSE) {
            return;
        }
        $this->end = $end;
        $this->status = Status::PAUSE;

        $diff = $this->start->diff($this->end);
        $this->time = $diff->format('%i:%s');
    }

    public function reset(): void {
        if($this->status == Status::PREPARE || $this->status == Status::MEASURE) {
            return;
        }
        $this->start = new \DateTimeImmutable();
        $this->end = new \DateTimeImmutable();
        $this->time = '00:00';
        $this->status = Status::PREPARE;
    }
}