<?php
namespace App\Bmi\Enums;

enum NutritionalStatus: String
{
    case SKINNY = '痩せ';
    case NORMAL = '普通体重';
    case PRE_OBESITY = '前肥満';
    case OBESITY_1 = '肥満(1度)';
    case OBESITY_2 = '肥満(2度)';
    case OBESITY_3 = '肥満(3度)';

    public static function fromValue(String $value): NutritionalStatus {
        return match($value) {
            '痩せ' => self::SKINNY,
            '普通体重' => self::NORMAL,
            '前肥満' => self::PRE_OBESITY,
            '肥満(1度)' => self::OBESITY_1,
            '肥満(2度)' => self::OBESITY_2,
            '肥満(3度)' => self::OBESITY_3,
        };
    }
}