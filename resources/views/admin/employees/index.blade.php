@extends('layouts.app')

@section('content')
<div class="container">
@can('manage employees')
    <h1 class="mb-4">Employees List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-3">
        Add New Employee
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Qualifications</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->qualifications }}</td>
                    <td>{{ $employee->age }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->gender }}</td>
                    <td>{{ $employee->date_of_birth ?? '-' }}</td>
                    <td class="d-flex gap-2 justify-content-center align-items-center">
                        {{-- أيقونة التعديل --}}
                        <a href="{{ route('admin.employees.edit', $employee) }}" title="Edit">
                            <i class="fas fa-edit action-icon"
                               style="font-size:1.5rem; color:#ffc107; cursor:pointer;"></i>
                        </a>

                        {{-- أيقونة الحذف --}}
                        @can('manage employees')
                        <form action="{{ route('admin.employees.destroy', $employee) }}"
                              method="POST" style="display:inline"
                              onsubmit="return confirm('Are you sure you want to delete this employee?')">
                            @csrf
                            @method('DELETE')
                            <i class="fas fa-trash action-icon danger"
                               title="Delete"
                               style="font-size:1.5rem; color:#dc3545; cursor:pointer;"
                               onclick="this.closest('form').submit()"></i>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        No employees found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endcan
</div>
@endsection
