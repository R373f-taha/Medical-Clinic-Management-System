@extends('layouts.app')

@section('content')
<div class="container-fluid px-3">

    <h1 class="mb-4">Medical Records</h1>

    <a href="{{ route('admin.medical-records.create') }}" class="btn btn-primary mb-3">
        Add New Record
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-2">

            <table class="table table-bordered table-hover table-sm align-middle text-center mb-0"
                   style="table-layout: fixed; width: 100%;">

                <thead class="table-light">
                    <tr>
                        <th style="width: 4%;">#</th>
                        <th style="width: 14%;">Patient</th>
                        <th style="width: 14%;">Doctor</th>
                        <th style="width: 20%;">Diagnosis</th>
                        <th style="width: 22%;">Treatment Plan</th>
                        <th style="width: 12%;">Follow-up Date</th>
                        <th style="width: 14%;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-truncate">
                                {{ $record->patient->user->name ?? 'N/A' }}
                            </td>

                            <td class="text-truncate">
                                {{ $record->doctor->user->name ?? 'N/A' }}
                            </td>

                            <td class="text-wrap small">
                                {{ $record->diagnosis }}
                            </td>

                            <td class="text-wrap small">
                                {{ $record->treatment_plan }}
                            </td>

                            <td>
                                {{ $record->follow_up_date
                                    ? \Carbon\Carbon::parse($record->follow_up_date)->format('Y-m-d')
                                    : 'N/A'
                                }}
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <a href="{{ route('admin.medical-records.edit', $record->id) }}"
                                    class="btn btn-warning btn-sm px-2 py-1">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.medical-records.destroy', $record->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm px-2 py-1">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No records found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $records->links() }}
    </div>

</div>
@endsection
