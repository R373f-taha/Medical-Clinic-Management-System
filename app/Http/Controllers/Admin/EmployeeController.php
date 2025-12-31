<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
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


    public function create() {}



    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        $this->employeeService->store($data);


        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }


    public function show(Employee $employee) {}


    public function edit(Employee $employee) {}


    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

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
