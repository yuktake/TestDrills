<?php
namespace App\DepartmentCode;

class Department {

    private DepartmentCode $departmentCode;

    private String $name;

    public function __construct(
        DepartmentCode $departmentCode,
        String $name
    ) {
        $this->departmentCode = $departmentCode;
        $this->name = $name;
    }

    public function getName():String {
        return $this->name;
    }
}