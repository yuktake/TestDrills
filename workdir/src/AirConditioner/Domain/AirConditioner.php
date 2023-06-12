<?php
namespace App\AirConditioner\Domain;

class AirConditioner {

    private RunningMode $mode;

    private bool $active;

    public function __construct(
        RunningMode $mode = RunningMode::COOLING,
    ) {
        $this->mode = $mode;
        $this->active = false;
    }

    public function getMode():RunningMode {
        return $this->mode;
    }

    public function isActive():bool {
        return $this->active;
    }

    public function run():void {
        $this->active = true;
    }

    public function stop():void {
        $this->active = false;
    }

    public function changeMode():void {
        if(!$this->active) {
            return;
        }
        if($this->mode == RunningMode::DEHUMIDIFYING) {
            $this->mode = RunningMode::COOLING;
            return;
        }

        $this->mode = RunningMode::fromValue($this->mode->value + 1);
    }
}