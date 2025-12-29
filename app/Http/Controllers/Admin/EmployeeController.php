<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\Admin\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getAll();
    }


    public function create()
    {
    }

  
    public function store(Request $request)
    {
    $data = $request->validate([
    'name'  => 'required|string|max:255',
    'email' => 'required|email|unique:employee,email',
    'phone' => 'required|string|max:20',
    'role'  => 'required|string|max:50',
]);

$this->employeeService->store($data);


        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }


    public function show(Employee $employee)
    {
    }


    public function edit(Employee $employee)
    {
    }

  
    public function update(Request $request, Employee $employee)
    {
     $data = $request->validate([
    'name'  => 'required|string|max:255',
    'email' => 'required|email|unique:employees,email,' . $employee->id, // اسم الجدول غالباً employees
    'phone' => 'required|string|max:20',
    'role'  => 'required|string|max:50',
]);

$this->employeeService->update($employee, $data);
        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم تعديل بيانات الموظف');
    }

 
    public function destroy(Employee $employee)
    {
        $this->employeeService->delete($employee);
        return back()->with('success', 'تم حذف الموظف');
    }
}
