<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  
    public function index()
    {
        $employees = Employee::latest()->get();
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

Employee::create($data);


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

$employee->update($data);
        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم تعديل بيانات الموظف');
    }

 
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'تم حذف الموظف');
    }
}
