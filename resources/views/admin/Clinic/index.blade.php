@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Clinic Information</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-3">
        <p><strong>Clinic Name:</strong> {{ $clinic->name }}</p>
        <p><strong>Address:</strong> {{ $clinic->address }}</p>
        <p><strong>Phone:</strong> {{ $clinic->phone }}</p>
        <p><strong>Email:</strong> {{ $clinic->email ?? '-' }}</p>

        <a href="{{ route('admin.clinic.edit', $clinic) }}" class="btn btn-primary mt-2">
            Edit Information
        </a>
    </div>
</div>
@endsection
