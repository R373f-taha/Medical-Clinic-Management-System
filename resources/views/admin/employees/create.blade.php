@extends('layouts.app')

@section('content')
<div class="container">
@can('manage employees')
    <h1 class="mb-4">Add Employee</h1>

    {{-- Display Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
        </div>

        {{-- Qualifications --}}
        <div class="mb-3">
            <label class="form-label">Qualifications</label>
            <input
                type="text"
                name="qualifications"
                class="form-control"
                value="{{ old('qualifications') }}"
                required
            >
        </div>

        {{-- Age --}}
        <div class="mb-3">
            <label class="form-label">Age</label>
            <input
                type="number"
                name="age"
                class="form-control"
                value="{{ old('age') }}"
                min="18"
                required
            >
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input
                type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone') }}"
                required
            >
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
            >
        </div>

        {{-- Gender --}}
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        {{-- Date of Birth --}}
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input
                type="date"
                name="date_of_birth"
                class="form-control"
                value="{{ old('date_of_birth') }}"
            >
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Save
            </button>

            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </form>
    @endcan
</div>
@endsection
