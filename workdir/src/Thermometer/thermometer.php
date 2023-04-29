<?php
namespace App\Thermometer;

class Thermometer {

    private float $temperature;

    private String $message;

    public function __construct(
        float $temperature,
    ) {
        if ($temperature < 24.0) {
            $this->message = '寒い';
        } else if ($temperature < 26.0) {
            $this->message = '快適';
        } else {
            $this->message = '暑い';
        }
        $this->temperature = $temperature;
    }

    public function getTemperature(): float {
        return $this->temperature;
    }

    public function getMessage(): String {
        return $this->message;
    }
}