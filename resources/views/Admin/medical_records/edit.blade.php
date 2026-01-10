@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Edit Medical Record</h1>

    <form action="{{ route('admin.medical-records.update', $medicalRecord->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ $medicalRecord->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Doctor</label>
            <select name="doctor_id" class="form-select" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}"
                        {{ $medicalRecord->doctor_id == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Diagnosis</label>
            <textarea name="diagnosis"
                      class="form-control"
                      rows="3"
                      required>{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Treatment Plan</label>
            <textarea name="treatment_plan"
                      class="form-control"
                      rows="3"
                      required>{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Follow-up Date</label>
            <input type="date"
                   name="follow_up_date"
                   class="form-control"
                   value="{{ old('follow_up_date', $medicalRecord->follow_up_date) }}">
        </div>

        <button type="submit" class="btn btn-success">
            Update Record
        </button>

        <a href="{{ route('admin.medical-records.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>
@endsection
