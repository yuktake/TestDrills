<?php
namespace App\Rpg\Weapons\Interface;

use App\Rpg\Enums\HandedType;

interface WeaponInterface {

    public function getHandedType():HandedType;

    public function enhance():self;

    public function getAttackPower():int;
}