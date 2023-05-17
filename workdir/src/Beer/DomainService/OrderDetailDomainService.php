<?php
namespace App\Beer\DomainService;

use App\Beer\Domain\Product;
use App\Beer\Repository\HappyHourRepository;

class OrderDetailDomainService {

    public function __construct(
        
    ) {
        
    }

    public function getHappyHourPrice(Product $product, \DateTimeImmutable $orderAt): int {
        $happyHourRepository = new HappyHourRepository();
        $happyHour = $happyHourRepository->getHappyHour();

        if ($happyHour->isWithinRange($orderAt)) {
            return $product->getHappyHourPrice();
        }

        return $product->getPrice();
    }
}