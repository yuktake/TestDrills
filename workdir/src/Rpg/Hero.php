<?php
namespace App\Rpg;

use App\Rpg\Weapons\Shield;

class Hero {

    const handNum = 2;

    private Array $weapons;

    private ?Shield $shield;

    public function __construct(
        Array $weapons,
        ?Shield $shield,
    ) {
        $useHandNum = 0;

        foreach($weapons as $weapon) {
            $interfaces = class_implements($weapon);
            $include = false;
            foreach ($interfaces as $key => $value) {
                if (str_contains($value, 'WeaponInterface')) {
                    $include = true;
                    break;
                }
            }
            if (!$include) {
                throw new \Exception('武器ではないものを装備しようとしています。');
            }

            $useHandNum+=$weapon->getHandedType()->value;
        }

        if (!is_null($shield)) {
            $useHandNum++;
        }

        if (self::handNum < $useHandNum) {
            throw new \Exception('装備できません');
        }

        $this->weapons = $weapons;
    }
}