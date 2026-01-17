@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto;">

        <div style="margin-bottom:20px;">
            <h2 style="color:#ff7a00;">Add New Prescription</h2>
        </div>

        <div style="background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:25px;">

        @can('manage prescriptions')
            <form action="{{ route('doctor.prescriptions.store') }}" method="POST">
                @csrf

                {{-- Patient Select --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Patient</label>
                    <select name="medical_record_id"
                            style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                            required>
                        <option value="">Select Patient</option>
                        @foreach($medicalRecords as $record)
                            <option value="{{ $record->id }}">
                                {{ $record->patient->user->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Medicine Name --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Medicine Name</label>
                    <input type="text" name="medicine_name"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                           required>
                </div>

                {{-- Dosage --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Dosage</label>
                    <input type="number" name="dosage" min="1"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                           required>
                </div>

                {{-- Frequency --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Frequency (times/day)</label>
                    <input type="number" name="frequency" min="1"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                           required>
                </div>

                {{-- Refills --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Refills</label>
                    <input type="text" name="refills"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                           required>
                </div>

                {{-- Instructions --}}
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Instructions</label>
                    <textarea name="instructions" rows="2"
                              style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                              required></textarea>
                </div>

                {{-- Duration --}}
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">Duration (days)</label>
                    <input type="number" name="duration" min="1"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"
                           required>
                </div>

                {{-- Buttons --}}
                <div style="display:flex; gap:10px;">
                    <button type="submit"
                            style="background-color:#ff7a00; color:#fff; padding:10px 20px;
                                   border:none; border-radius:6px; cursor:pointer;">
                        Save
                    </button>

                    <a href="{{ route('doctor.prescriptions.index') }}"
                       style="background-color:#6c757d; color:#fff; padding:10px 20px;
                              text-decoration:none; border-radius:6px;">
                        Cancel
                    </a>
                </div>

            </form>
        @endcan

        </div>
    </div>
</div>
@endsection
