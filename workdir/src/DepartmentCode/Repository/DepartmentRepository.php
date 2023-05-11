<?php
namespace App\DepartmentCode\Repository;

use App\DepartmentCode\Consts\Department;
use App\DepartmentCode\DepartmentCode;
use App\DepartmentCode\Interface\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface {

    public function checkExist(DepartmentCode $departmentCode):bool {
        
        return isset(Department::DEPARTMENT_TABLE[$departmentCode->getValue()]);
    }
}