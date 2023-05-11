<?php

use App\BaggageSize\BaggageSize;
use App\BaggageSize\Enums\BaggageSizeStandard;
use PHPUnit\Framework\TestCase;

class BaggageSizeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 荷物サイズは３辺の合計と重量の大きいほうで決まる用データ
     */
    public function 荷物サイズは３辺の合計と重量の大きいほうで決まる(
        int $baggageTotalLength,
        int $weight,
        String $expectedBaggageSizeOutput,
    ) {
        $baggageSizeOutput = null;

        try {
            $baggageSize = new BaggageSize(
                $baggageTotalLength,
                $weight,
            );
            $baggageSizeOutput =  BaggageSizeStandard::output($baggageSize->getValue());
        } catch(\Exception $e) {
            $baggageSizeOutput = $e->getMessage();
        }
        
        $this->assertEquals($expectedBaggageSizeOutput, $baggageSizeOutput);
    }

    public static function 荷物サイズは３辺の合計と重量の大きいほうで決まる用データ() {
        return [
            '3辺合計が60cm以下で重量が2kg以下' => [
                0,
                0,
                '60サイズ'
            ],
            '3辺合計が60cm以下で重量が2kgより大きく、5kg以下' => [
                30,
                3,
                '80サイズ'
            ],
            '3辺合計が60cm以下で重量が5kgより大きく、10kg以下' => [
                60,
                7,
                '100サイズ'
            ],
            '3辺合計が60cm以下で重量が10kgより大きい' => [
                60,
                100,
                'エラー'
            ],
            '3辺合計が60cmより大きく、80cm以下で重量が2kg以下' => [
                61,
                2,
                '80サイズ'
            ],
            '3辺合計が60cmより大きく、80cm以下で重量が2kgより大きく、5kg以下' => [
                70,
                5,
                '80サイズ'
            ],
            '3辺合計が60cmより大きく、80cm以下で重量が5kgより大きく、10kg以下' => [
                80,
                7,
                '100サイズ'
            ],
            '3辺合計が60cmより大きく、80cm以下で重量が10kgより大きい' => [
                70,
                11,
                'エラー'
            ],
            '3辺合計が80cmより大きく、100cm以下で重量が2kg以下' => [
                81,
                0,
                '100サイズ'
            ],
            '3辺合計が80cmより大きく、100cm以下で重量が2kgより大きく、5kg以下' => [
                100,
                5,
                '100サイズ'
            ],
            '3辺合計が80cmより大きく、100cm以下で重量が5kgより大きく、10kg以下' => [
                100,
                10,
                '100サイズ'
            ],
            '3辺合計が80cmより大きく、100cm以下で重量が10kgより大きい' => [
                100,
                100,
                'エラー'
            ],
            '3辺合計が100cmより大きく、重量が2kg以下' => [
                101,
                2,
                'エラー'
            ],
            '3辺合計が100cmより大きく、重量が2kgより大きく、5kg以下' => [
                101,
                5,
                'エラー'
            ],
            '3辺合計が100cmより大きく、重量が5kgより大きく、10kg以下' => [
                101,
                10,
                'エラー'
            ],
            '3辺合計が100cmより大きく、重量が10kgより大きい' => [
                101,
                100,
                'エラー'
            ],
        ];
    }
}