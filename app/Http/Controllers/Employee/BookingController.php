<?php

namespace App\Http\Controllers\Employee;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\Employee\BookingService;
use App\Http\Requests\Store\StoreBookingRequest;
use App\Http\Requests\Update\UpdateBookingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected BookingService $service;

    /**
     * BookingController constructor.
     *
     * @param BookingService $service Service responsible for booking operations
     */
    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a list of all bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bookings = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date')
            ->get();

        return view('Employee.Booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors  = Doctor::with('user')->get();

        return view('Employee.Booking.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created booking in the database.
     *
     * @param StoreBookingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

public function store(StoreBookingRequest $request)
{
    DB::beginTransaction();

    try {
        $this->service->createBooking($request->validated());
        DB::commit();

        return redirect()
            ->route('employee.bookings.index')
            ->with('success', 'Booking created successfully.');
    }
    catch (ValidationException $e) {
        DB::rollBack();

        // This keeps errors under the correct input fields
        return back()
            ->withErrors($e->errors())
            ->withInput();
    }
    catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Create booking failed', [
            'error' => $e->getMessage()
        ]);

        return back()
            ->withErrors(['error' => 'Something went wrong. Please try again.'])
            ->withInput();
    }
}


    /**
     * Show the form for editing the specified booking.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $booking = Appointment::findOrFail($id);
        return view('Employee.Booking.edit', compact('booking'));
    }

    /**
     * Update the specified booking in the database.
     *
     * @param UpdateBookingRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

public function update(UpdateBookingRequest $request, $id)
{
    DB::beginTransaction();

    try {
        $this->service->updateBooking(
            $id,
            $request->appointment_date,
            $request->reason
        );

        DB::commit();

        return redirect()
            ->route('employee.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }
    catch (ValidationException $e) {
        DB::rollBack();

        return back()
            ->withErrors($e->errors())
            ->withInput();
    }
    catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Update booking failed', [
            'id'    => $id,
            'error' => $e->getMessage()
        ]);

        return back()
            ->withErrors(['error' => 'Something went wrong. Please try again.'])
            ->withInput();
    }
}

    /**
     * Approve the specified booking.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $this->service->approve($id);
            DB::commit();

            return back()->with('success', 'Booking approved.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Approve booking failed', ['id' => $id, 'error' => $e->getMessage()]);

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Reject the specified booking.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        DB::beginTransaction();
        try {
            $this->service->reject($id);
            DB::commit();

            return back()->with('success', 'Booking rejected.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Reject booking failed', ['id' => $id, 'error' => $e->getMessage()]);

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete the specified booking from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Appointment::findOrFail($id)->delete();
            DB::commit();

            return back()->with('success', 'Booking deleted successfully.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete booking failed', ['id' => $id, 'error' => $e->getMessage()]);

            return back()->withErrors(['error' => 'Unable to delete booking.']);
        }
    }

    /**
     * Mark the specified booking as completed.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete($id)
    {
        DB::beginTransaction();
        try {
            $this->service->complete($id);
            DB::commit();

            return back()->with('success', 'Booking marked as completed.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Complete booking failed', ['id' => $id, 'error' => $e->getMessage()]);

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
