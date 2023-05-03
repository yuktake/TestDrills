<?php

use App\Butcher\Order;
use App\Butcher\OrderDate;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider １日から５日に買い物すると２割引になる用データ
     */
    public function １日から５日に買い物すると２割引になる(
        \DateTimeImmutable $orderAt,
        int $expectedPrice,
    ) {
        $order = new Order(
            1000,
            new OrderDate($orderAt),
        );

        $this->assertEquals($expectedPrice, $order->getTotalPrice());
    }

    /**
     * @test
     * @dataProvider ２８日から３０日に買い物すると２割引になる用データ
     */
    public function ２８日から３０日に買い物すると２割引になる(
        \DateTimeImmutable $orderAt,
        int $expectedPrice,
    ) {
        $order = new Order(
            1000,
            new OrderDate($orderAt),
        );

        $this->assertEquals($expectedPrice, $order->getTotalPrice());
    }

    public static function １日から５日に買い物すると２割引になる用データ() {
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
            '6日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-06'),
                1000,
            ],
            '20日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-20'),
                1000,
            ],
        ];
    }

    public static function ２８日から３０日に買い物すると２割引になる用データ() {
        return [
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
            '31日に購入' => [
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-31'),
                1000,
            ],
        ];
    }
}