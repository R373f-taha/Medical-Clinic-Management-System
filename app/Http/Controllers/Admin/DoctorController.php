<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreDoctorRequest;
use App\Http\Requests\Update\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\Admin\DoctorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    protected DoctorService $doctorService;

    /**
     * DoctorController constructor.
     *
     * @param DoctorService $doctorService Service responsible for doctor-related operations
     */
    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Display a list of all doctors.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $doctors = $this->doctorService->getAll();
            return view('Admin.doctors.index', compact('doctors'));
        } catch (\Throwable $e) {
            Log::error('Fetching doctors failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch doctors.']);
        }
    }

    /**
     * Show the form for creating a new doctor.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            $users = $this->doctorService->getUsers();
            return view('Admin.doctors.create', compact('users'));
        } catch (\Throwable $e) {
            Log::error('Fetching users failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load create doctor form.']);
        }
    }

    /**
     * Store a newly created doctor in the database.
     *
     * @param StoreDoctorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDoctorRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $this->doctorService->store($data);
            DB::commit();

            return redirect()->route('admin.doctors.index')
                             ->with('success', 'Doctor added successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Store doctor failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add doctor.'])->withInput();
        }
    }

    /**
     * Display the schedule of a specific doctor.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $doctor = Doctor::with('appointments.patient.user')->findOrFail($id);
            return view('Admin.doctors.schedule', compact('doctor'));
        } catch (\Throwable $e) {
            Log::error('Show doctor schedule failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to display doctor schedule.']);
        }
    }

    /**
     * Show the form for editing a doctor.
     *
     * @param Doctor $doctor
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Doctor $doctor)
    {
        try {
            $users = $this->doctorService->getUsers();
            return view('Admin.doctors.edit', compact('doctor', 'users'));
        } catch (\Throwable $e) {
            Log::error('Edit doctor failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load edit form.']);
        }
    }

    /**
     * Update the specified doctor in the database.
     *
     * @param UpdateDoctorRequest $request
     * @param Doctor $doctor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        DB::beginTransaction();
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->doctorService->update($doctor, $data);
            DB::commit();

            return redirect()->route('admin.doctors.index')
                             ->with('success', 'Doctor updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update doctor failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update doctor.'])->withInput();
        }
    }

    /**
     * Delete the specified doctor from the database.
     *
     * @param Doctor $doctor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Doctor $doctor)
    {
        DB::beginTransaction();
        try {
            $this->doctorService->delete($doctor);
            DB::commit();

            return redirect()->route('admin.doctors.index')
                             ->with('success', 'Doctor deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete doctor failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete doctor.']);
        }
    }
}
