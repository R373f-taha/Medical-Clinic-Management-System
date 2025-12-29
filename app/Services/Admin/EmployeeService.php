<?php

namespace App\Services\Admin;

use App\Models\Employee;

class EmployeeService
{
    public function getAll()
    {
        return Employee::latest()->get();
    }

    public function store(array $data)
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data)
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee)
    {
        return $employee->delete();
    }
}