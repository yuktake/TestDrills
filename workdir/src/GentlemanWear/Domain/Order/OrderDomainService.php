<?php
namespace App\GentlemanWear\Domain\Order;

use App\GentlemanWear\Domain\Money;

class OrderDomainService {

    public function __construct(
        
    ) {
        
    }

    public function applyDiscounts(Order $order):Order {
        $discountRatio = 0.0;
        $orderDetails = $order->getOrderDetails();
        // セット割引
        if ($orderDetails->hasCategory('y-shirt') && $orderDetails->hasCategory('tie')) {
            $discountRatio+=0.05;
        }

        // 創立記念セール割引
        if (count($orderDetails->asArray()) >= 7 && $this->isAnniversaryOfFounding($order->getOrderAt())) {
            $discountRatio+=0.07;
        }

        $discountPrice = $order->getPrice() * $discountRatio;

        $order = new Order(
            $order->getId(),
            new Money($order->getPrice() - $discountPrice),
            $order->getOrderDetails(),
            $order->getOrderAt(),
        );

        return $order;
    }

    private function isAnniversaryOfFounding(\DateTimeImmutable $orderAt):bool {
        $endOfMonth = intval($orderAt->format('t'));
        $weekNum = 1;
        if($orderAt->format('n') != 5) {
            return false;
        }

        for ($i=1; $i <= $endOfMonth; $i++) { 
            $dateTime = \DateTimeImmutable::createFromFormat('Y-m-j H:i:s', $orderAt->format('Y-m').'-'.$i.' 00:00:00');
            if($dateTime->format('w') === '0') {
                $weekNum++;
            }
            if($orderAt->format('j') == $i) {
                $orderedWeek = $weekNum;
            }
        }

        if($orderedWeek == $weekNum) {
            return true;
        }

        return false;
    }
}