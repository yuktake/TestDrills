<?php

use App\TatamiConverter\TatamiConverter;
use PHPUnit\Framework\TestCase;

class tatamiConverterTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 適切な畳数を設定する用データ
     * @param $weight
     */
    public function 適切な畳数を設定する(
        int $tatamiNum,
        String $expectedArea,
    ) {
        $area = null;

        try{
            $tatamiConverter = new TatamiConverter($tatamiNum);
            $area = strval($tatamiConverter->getArea()).'㎡';
        } catch (\InvalidArgumentException $e) {
            $area = '-';
        } catch (\Exception $e) {
            $area = $e->getMessage();
        }

        $this->assertEquals($expectedArea, $area);
    }

    public static function 適切な畳数を設定する用データ() {
        return [
            [-200, '-'],
            [-129, '-'],
            [-128, '畳数は１以上を入力してください。'],
            [-100, '畳数は１以上を入力してください。'],
            [0, '畳数は１以上を入力してください。'],
            [1, '1.65㎡'],
            [12, '19.8㎡'],
            [127, '209.55㎡'],
            [128, '-'],
            [200, '-'],
        ];
    }
}