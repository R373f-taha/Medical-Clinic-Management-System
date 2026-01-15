<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreEmployeeRequest;
use App\Http\Requests\Update\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\Admin\EmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeService $employeeService Service responsible for employee operations
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a list of all employees.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $employees = $this->employeeService->getAll();
            return view('admin.employees.index', compact('employees'));
        } catch (\Throwable $e) {
            Log::error('Fetching employees failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch employees.']);
        }
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in the database.
     *
     * @param StoreEmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $this->employeeService->store($data);
            DB::commit();

            return redirect()->route('admin.employees.index')
                             ->with('success', 'Employee added successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Store employee failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add employee.'])->withInput();
        }
    }

    /**
     * Show the form for editing an existing employee.
     *
     * @param Employee $employee
     * @return \Illuminate\View\View
     */
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in the database.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->employeeService->update($employee, $data);
            DB::commit();

            return redirect()->route('admin.employees.index')
                             ->with('success', 'Employee updated successfully.');
        }
         catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update employee failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update employee.'])->withInput();
        }
    }

    /**
     * Delete the specified employee from the database.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            $this->employeeService->delete($employee);
            DB::commit();

            return redirect()->route('admin.employees.index')
                             ->with('success', 'Employee deleted successfully.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete employee failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete employee.']);
        }
    }
}
