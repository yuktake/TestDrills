<?php
namespace App\Rpg\Weapons;

use App\Rpg\Enums\HandedType;

class Shield {

    const HandedType = HandedType::SINGLE_HANDED;

    public function getHandedType():HandedType
    {
        return self::HandedType;
    }
}