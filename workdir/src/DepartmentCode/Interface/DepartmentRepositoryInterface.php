<?php
namespace App\DepartmentCode\Interface;

use App\DepartmentCode\DepartmentCode;

interface DepartmentRepositoryInterface {

    public function checkExist(DepartmentCode $departmentCode):bool;
    
}