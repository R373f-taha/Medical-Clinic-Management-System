@extends('layouts.app')

@section('content')
<h1>Add New Medical Record</h1>

{{-- Display validation errors if any --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.medical-records.store') }}" method="POST">
    @csrf

    {{-- Select Patient --}}
    <div class="mb-3">
        <label for="patient_id" class="form-label">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            <option value="">Select a patient</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                    {{ $patient->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Select Doctor --}}
    <div class="mb-3">
        <label for="doctor_id" class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            <option value="">Select a doctor</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Diagnosis Field --}}
    <div class="mb-3">
        <label for="diagnosis" class="form-label">Diagnosis</label>
        <textarea name="diagnosis" id="diagnosis" class="form-control">{{ old('diagnosis') }}</textarea>
    </div>

    {{-- Treatment Plan Field --}}
    <div class="mb-3">
        <label for="treatment_plan" class="form-label">Treatment Plan</label>
        <textarea name="treatment_plan" id="treatment_plan" class="form-control">{{ old('treatment_plan') }}</textarea>
    </div>

    {{-- Follow-up Date Field --}}
    <div class="mb-3">
        <label for="follow_up_date" class="form-label">Follow-up Date</label>
        <input type="date" name="follow_up_date" id="follow_up_date" class="form-control" value="{{ old('follow_up_date') }}">
    </div>

    {{-- Save and Back Buttons --}}
    <button type="submit" class="btn btn-success">Save Record</button>
    <a href="{{ route('admin.medical-records.index') }}" class="btn btn-secondary">Back to Records</a>
</form>
@endsection
