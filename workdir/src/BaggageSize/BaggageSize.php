<?php
namespace App\BaggageSize;

use App\BaggageSize\Enums\BaggageLengthStandard;
use App\BaggageSize\Enums\BaggageSizeStandard;
use App\BaggageSize\Enums\BaggageWeightStandard;

class BaggageSize {

    private BaggageSizeStandard $baggageSizeStandard;

    public function __construct(
        int $baggageTotalLength,
        int $weight,
    ) {
        if ($baggageTotalLength <= 60) {
            $baggageLengthStandard = BaggageLengthStandard::SIXTY_OR_LESS_CENTIMETER;
        } else if ($baggageTotalLength <= 80) {
            $baggageLengthStandard = BaggageLengthStandard::SIXTY_ONE_OR_MORE_AND_EIGHTY_OR_LESS_CENTIMETER;
        } else if ($baggageTotalLength <= 100) {
            $baggageLengthStandard = BaggageLengthStandard::EIGHTY_ONE_OR_MORE_AND_HUNDRED_OR_LESS_CENTIMETER;
        } else {
            throw new \Exception('エラー');
        }

        if ($weight <= 2) {
            $baggageWeightStandard = BaggageWeightStandard::TWO_OR_LESS_KILOGRAMME;
        } else if ($weight <= 5) {
            $baggageWeightStandard = BaggageWeightStandard::MORE_THAN_TWO_AND_FIVE_OR_LESS_KILOGRAMME;
        } else if ($weight <= 10) {
            $baggageWeightStandard = BaggageWeightStandard::MORE_THAN_FIVE_AND_TEN_OR_LESS_KILOGRAMME;
        } else {
            throw new \Exception('エラー');
        }

        $baggageSizeStandardValue = max([$baggageLengthStandard->value, $baggageWeightStandard->value]);

        $this->baggageSizeStandard = BaggageSizeStandard::fromValue($baggageSizeStandardValue);
    }

    public function getValue(): int {
        return $this->baggageSizeStandard->value;
    }
}