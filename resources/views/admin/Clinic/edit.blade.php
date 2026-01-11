@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Clinic Information</h1>
   @can('manage clinic') 
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.clinic.update', $clinic) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Clinic Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $clinic->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control"
                   value="{{ old('address', $clinic->address) }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $clinic->phone) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $clinic->email) }}">
        </div>

        <button class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.clinic.index') }}" class="btn btn-secondary">Back</a>
    </form>
    @endcan
</div>
@endsection
