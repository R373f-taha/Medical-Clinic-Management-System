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

                        {{-- Edit --}}
                        <a href="{{ route('admin.employees.edit', $employee) }}" title="Edit">
                            <i class="fas fa-edit action-icon"
                               style="font-size:1.5rem; color:#ffc107; cursor:pointer;"></i>
                        </a>

                        {{-- Delete --}}
                        @can('manage employees')
                        <form id="delete-form-{{ $employee->id }}" 
                              action="{{ route('admin.employees.destroy', $employee) }}" 
                              method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="action-icon danger" 
                                    title="Delete" 
                                    style="font-size:1.5rem; color:#dc3545; border:none; background:none; cursor:pointer;"
                                    onclick="confirmDelete({{ $employee->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
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

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action will permanently delete this employee!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

<style>
.action-icon { font-size: 1.5rem; cursor: pointer; }
.action-icon.danger:hover { opacity: 0.7; }
</style>
@endsection
