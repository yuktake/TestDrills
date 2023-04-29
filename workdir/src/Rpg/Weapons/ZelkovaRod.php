<?php
namespace App\Rpg\Weapons;

use App\Rpg\Enums\HandedType;
use App\Rpg\Weapons\Interface\WeaponInterface;

class ZelkovaRod implements WeaponInterface {

    const HandedType = HandedType::SINGLE_HANDED;

    const BaseAttack = 5;

    const canEnhance = false;

    public function __construct(
        bool $enhanced,
    ) {
        if ($enhanced) {
            throw new \Exception('この武器は強化できません');
        }
        $this->enhanced = $enhanced;
    }

    public function getHandedType():HandedType
    {
        return self::HandedType;
    }

    public function enhance(): WeaponInterface
    {
        if (!self::canEnhance) {
            throw new \Exception('武器の強化に失敗しました');
        }

        if ($this->enhanced) {
            throw new \Exception('これ以上この武器の強化はできません');
        }
        return new ZelkovaRod(enhanced: true);
    }

    public function getAttackPower():int {
        if ($this->enhanced) {
            return self::BaseAttack + 10;
        } else {
            return self::BaseAttack;
        }
    }
}