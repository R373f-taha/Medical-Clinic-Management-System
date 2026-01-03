@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Employee</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- User ID --}}
        <div class="mb-3">
            <label class="form-label">User ID</label>
            <input
                type="number"
                name="user_id"
                class="form-control"
                value="{{ old('user_id', $employee->user_id) }}"
            >
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $employee->name) }}"
            >
        </div>

        {{-- Qualifications --}}
        <div class="mb-3">
            <label class="form-label">Qualifications</label>
            <input
                type="text"
                name="qualifications"
                class="form-control"
                value="{{ old('qualifications', $employee->qualifications) }}"
            >
        </div>

        {{-- Age --}}
        <div class="mb-3">
            <label class="form-label">Age</label>
            <input
                type="number"
                name="age"
                class="form-control"
                value="{{ old('age', $employee->age) }}"
            >
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
            <button class="btn btn-success">Update</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
