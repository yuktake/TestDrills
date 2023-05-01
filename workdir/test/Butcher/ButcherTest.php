<?php

use App\Butcher\Order;
use App\Butcher\OrderDate;
use PHPUnit\Framework\TestCase;

class ButcherTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 日付による買い物金額の割引用データ
     */
    public function 日付による買い物金額の割引(
        \DateTimeImmutable $orderAt,
        int $expectedPrice,
    ) {
        $order = new Order(
            1000,
            new OrderDate($orderAt),
        );

        $this->assertEquals($expectedPrice, $order->getTotalPrice());
    }

    public static function 日付による買い物金額の割引用データ() {
        return [
            '1日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                800,
            ],
            '3日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-03'),
                800,
            ],
            '5日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-05'),
                800,
            ],
            // error
            '6日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-06'),
                1000,
            ],
            // error
            '20日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-20'),
                1000,
            ],
            // error
            '27日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-27'),
                1000,
            ],
            '28日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-28'),
                800,
            ],
            '29日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-29'),
                800,
            ],
            '30日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-30'),
                800,
            ],
            // error
            '31日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-31'),
                1000,
            ],
        ];
    }
}