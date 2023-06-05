<?php
namespace App\PrepaidCard\Service;

use App\PrepaidCard\Domain\Coupon;
use App\PrepaidCard\Domain\PrepaidCard;
use App\PrepaidCard\Enum\ChargeAmount;
use App\PrepaidCard\Repository\CouponRepository;

class PrepaidCardService {

    private $couponRepository;

    public function __construct(
        CouponRepository $couponRepository,
    ) {
        $this->couponRepository = $couponRepository;
    }

    public function charge(PrepaidCard $prepaidCard, ChargeAmount $chargeAmount, int $probability):PrepaidCard {
        $prepaidCard->charge($chargeAmount);

        if ($probability >= Coupon::ISSUE_PROBABILITY && $chargeAmount != ChargeAmount::SMALL) {
            $this->couponRepository->issue($prepaidCard->getCustomer());
        }

        return $prepaidCard;
    }
}