<?php

use App\DepartmentCode\Department;
use App\DepartmentCode\DepartmentCode;
use App\DepartmentCode\Repository\DepartmentRepository;
use PHPUnit\Framework\TestCase;

class DepartmentCodeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 部署コードには3桁の整数が割り振られている用データ
     */
    public function 部署コードには3桁の整数が割り振られている(
        int $departmentCodeInput,
        String $expectedDepartmentName,
    ) {
        $departmentName = null;
        $departmentRepository = new DepartmentRepository();

        try {
            $departmentCode = new DepartmentCode(
                $departmentCodeInput,
            );
            $departmentExist = $departmentRepository->checkExist($departmentCode);
            if (!$departmentExist) {
                throw new \Exception('該当する部署がありません');
            }

            $department = new Department(
                $departmentCode,
                $expectedDepartmentName
            );
            $departmentName = $department->getName();
        } catch(\Exception $e) {
            $departmentName = $e->getMessage();
        }

        $this->assertEquals($expectedDepartmentName, $departmentName);
    }

    /**
     * @test
     * @dataProvider 部署コードが該当しない場合エラーを返す用データ
     */
    public function 部署コードが該当しない場合エラーを返す(
        int $departmentCodeInput,
        String $expectedDepartmentName,
    ) {
        $departmentName = null;
        $departmentRepository = new DepartmentRepository();

        try {
            $departmentCode = new DepartmentCode(
                $departmentCodeInput,
            );

            $departmentExist = $departmentRepository->checkExist($departmentCode);
            if (!$departmentExist) {
                throw new \Exception('該当する部署がありません');
            }

            $department = new Department(
                $departmentCode,
                $expectedDepartmentName
            );
            $departmentName = $department->getName();
        } catch(\Exception $e) {
            $departmentName = $e->getMessage();
        }

        $this->assertEquals($expectedDepartmentName, $departmentName);
    }

    public static function 部署コードには3桁の整数が割り振られている用データ() {
        return [
            '部署コードが2桁の場合' => [
                99,
                'Error'
            ],
            '部署コードが3桁の場合' => [
                100,
                '本店総務部'
            ],
            '部署コードが4桁の場合' => [
                1000,
                'Error'
            ],
        ];
    }

    public static function 部署コードが該当しない場合エラーを返す用データ() {
        return [
            '部署コードが存在しない場合' => [
                999,
                '該当する部署がありません',
            ],
            '部署コードが存在する場合' => [
                100,
                '本店総務部',
            ],
        ];
    }
}