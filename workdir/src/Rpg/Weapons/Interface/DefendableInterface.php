<?php
namespace App\Rpg\Weapons\Interface;

// 防御系装備を判別するための型
interface DefendableInterface {

    public function getDefensiveStrength():int;
}