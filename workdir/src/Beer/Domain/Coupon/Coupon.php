<?php
namespace App\Beer\Domain\Coupon;

use App\Beer\Domain\Order;
use App\Beer\Enums\CouponTarget;
use App\Beer\Enums\DiscountType;

class Coupon implements CouponInterface {

    private ?int $id;

    private String $couponCode;

    private CouponConditions $conditions;

    private CouponSpecifications $specifications;

    private ?int $useLimit;

    private ?int $useLimitByCustomer;

    private AvailablePeriod $availablePeriod;

    public function __construct(
        ?int $id,
        String $couponCode,
        CouponConditions $conditions,
        CouponSpecifications $specifications,
        ?int $useLimit,
        ?int $useLimitByCustomer,
        AvailablePeriod $availablePeriod,
    ) {
        $this->id = $id;
        $this->couponCode = $couponCode;
        $this->conditions = $conditions;
        $this->specifications = $specifications;
        $this->useLimit = $useLimit;
        $this->useLimitByCustomer = $useLimitByCustomer;
        $this->availablePeriod = $availablePeriod;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function isApplicable(Order $order): bool {
        return $this->conditions->appliable($order);
    }

    public function apply(Order $order):Order {
        $appliedOrder = $this->specifications->apply($order);

        return $appliedOrder;
    }

    public function getUseLimit(): ?int
    {
        return $this->useLimit;
    }

    public function getUseLimitByCustomer(): ?int
    {
        return $this->useLimitByCustomer;
    }

    public function getCouponTarget(): CouponTarget
    {
        return CouponTarget::PRODUCT_CODE;
    }

    public function getDiscountType(): DiscountType
    {
        return DiscountType::SPECIFIC_PRICE;
    }

    public function isAvailable(): bool
    {
        return $this->availablePeriod->isAvailable(new \DateTimeImmutable());
    }
}