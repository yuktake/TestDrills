<?php
namespace App\Butcher\Interface;

// 防御系装備を判別するための型
interface DiscountInterface {

    public function getValue():int;
}