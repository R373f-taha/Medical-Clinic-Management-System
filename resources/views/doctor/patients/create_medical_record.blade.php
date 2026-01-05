@extends('doctor.layouts.app')

@section('content')
    <div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

        <div style="max-width:800px; margin:auto; background:#fff; padding:30px; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1)">

            <h2 style="color:#ff7a00; margin-bottom:20px;">
                Add Medical Record
            </h2>

            <form action="{{ route('doctor.medical_records.store') }}" method="POST">
                @csrf
                <!-- doctor -->
                <input type="hidden" name="doctor_id" value="{{ Auth::user()->doctor->id }}">
                <!-- Patient -->
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:6px;">Patient</label>
                    <select name="patient_id" required
                        style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">
                                Patient({{ $patient->id}}) : {{ $patient->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Diagnosis -->
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:6px;">Diagnosis</label>
                    <textarea name="diagnosis" rows="3"
                        style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"></textarea>
                </div>

                <!-- Notes -->
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:6px;">Notes</label>
                    <textarea name="notes" rows="3"
                        style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"></textarea>
                </div>

                <!-- Treatment Plan -->
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:6px;">Treatment Plan</label>
                    <textarea name="treatment_plan" rows="3"
                        style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"></textarea>
                </div>

                <!-- Follow Up Date -->
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:6px;">Follow Up Date</label>
                    <input type="date" name="follow_up_date"
                        style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px;">
                    <button type="submit" style="background-color:#ff7a00; color:#fff; padding:10px 18px;
                                    border:none; border-radius:6px; cursor:pointer;">
                        Save
                    </button>

                    <a href="{{ route('doctor.medical_records.index') }}" style="background-color:#6c757d; color:#fff; padding:10px 18px;
                                text-decoration:none; border-radius:6px;">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>
@endsection
