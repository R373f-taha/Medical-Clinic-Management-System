<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreEmployeeRequest;
use App\Http\Requests\Update\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\Admin\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    // عرض كل الموظفين
    public function index()
    {
        $employees = $this->employeeService->getAll();
        return view('admin.employees.index', compact('employees'));
    }

    // نموذج إضافة موظف
    public function create()
    {
        return view('admin.employees.create');
    }

    // حفظ موظف جديد
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        $this->employeeService->store($data);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }

    // نموذج تعديل موظف
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    // تحديث بيانات الموظف
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $this->employeeService->update($employee, $data);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم تعديل بيانات الموظف');
    }

    // حذف موظف
    public function destroy(Employee $employee)
    {
        $this->employeeService->delete($employee);
        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم حذف الموظف');
    }
}
