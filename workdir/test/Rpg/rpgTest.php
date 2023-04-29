<?php

use App\Rpg\Hero;
use App\Rpg\Weapons\DragonSpear;
use App\Rpg\Weapons\Interface\WeaponInterface;
use App\Rpg\Weapons\LumberjackAxe;
use App\Rpg\Weapons\Shield;
use App\Rpg\Weapons\ZelkovaRod;
use PHPUnit\Framework\TestCase;

class rpgTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 装備可能テスト用データ
     */
    public function 装備可能テスト(
        Array $weapons,
        Shield $shield,
        String $expectedMessage,
    ) {
        $message = '';

        try {
            new Hero(
                $weapons,
                $shield
            );
        }catch(\Exception $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals($expectedMessage, $message);
    }

    /**
     * @test
     * @dataProvider 強化可能テスト用データ
     */
    public function 強化可能テスト(
        WeaponInterface $weapon,
        String $expectedMessage,
        int $expectedAttack,
    ) {
        $message = null;
        $attack = $weapon->getAttackPower();
        try {
            $enhancedWeapon = $weapon->enhance();
            $message = '武器の攻撃力が上がりました';
            $attack = $enhancedWeapon->getAttackPower();
        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals($expectedMessage, $message);
        $this->assertEquals($expectedAttack, $attack);
    }

    public static function 装備可能テスト用データ() {
        return [
            '何も装備しない' => [
                [],
                new Shield(),
                '',
            ],
            '片手持ちを装備' => [
                [new ZelkovaRod(enhanced: false),],
                new Shield(),
                '',
            ],
            '両手持ちを装備' => [
                [new LumberjackAxe(enhanced: false),],
                new Shield(),
                '装備できません',
            ],
            '武器でないものを装備' => [
                [new Shield(),],
                new Shield(),
                '武器ではないものを装備しようとしています。',
            ],
        ];
    }

    public static function 強化可能テスト用データ() {
        return [
            '強化可能な武器を強化する' => [
                new DragonSpear(enhanced: false),
                '武器の攻撃力が上がりました',
                DragonSpear::BaseAttack+10,
            ],
            '強化済みの武器を強化する' => [
                new DragonSpear(enhanced: true),
                'これ以上この武器の強化はできません',
                DragonSpear::BaseAttack+10,
            ],
            '強化不可能な武器を強化する' => [
                new ZelkovaRod(enhanced: false),
                '武器の強化に失敗しました',
                ZelkovaRod::BaseAttack,
            ],
        ];
    }
}