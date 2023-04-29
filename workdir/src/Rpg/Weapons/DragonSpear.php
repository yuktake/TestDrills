<?php
namespace App\Rpg\Weapons;

use App\Rpg\Enums\HandedType;
use App\Rpg\Weapons\Interface\WeaponInterface;

class DragonSpear implements WeaponInterface {

    const HandedType = HandedType::TWO_HANDED;

    const BaseAttack = 50;

    const canEnhance = true;

    public function __construct(
        bool $enhanced,
    ) {
        $this->enhanced = $enhanced;
    }

    public function getHandedType():HandedType
    {
        return self::HandedType;
    }

    public function enhance(): WeaponInterface
    {
        if (!self::canEnhance) {
            throw new \Exception('武器の強化に失敗しました。');
        }

        if ($this->enhanced) {
            throw new \Exception('これ以上この武器の強化はできません');
        }
        return new DragonSpear(enhanced: true);
    }

    public function getAttackPower():int {
        if ($this->enhanced) {
            return self::BaseAttack + 10;
        } else {
            return self::BaseAttack;
        }
    }
}