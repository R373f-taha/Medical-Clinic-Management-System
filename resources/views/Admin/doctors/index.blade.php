
@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    @can('manage doctors')

    <div style="max-width:1200px; margin:auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Doctors
            </h2>

            <a href="{{ route('admin.doctors.create') }}"
               style="background-color:#ff7a00; color:#fff; padding:10px 16px;
                      text-decoration:none; border-radius:6px;">
                + Add New Doctor
            </a>
        </div>

        <div style="overflow-x:auto; background:#ffffff; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1)">

            <table style="width:100%; border-collapse:collapse; text-align:center;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px;">doctor name</th>
                        <th style="padding:12px;">Specialization</th>
                        <th style="padding:12px;">Qualifications</th>
                        <th style="padding:12px;">Available Hours</th>
                        <th style="padding:12px;">Experience</th>
                        <th style="padding:12px;">service</th>
                        <th style="padding:12px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">
                              {{ $doctor->user->name }}
                            </td>

                            <td style="padding:10px;">
                                {{ $doctor->specialization }}
                            </td>

                            <td style="padding:10px;">
                                {{ $doctor->qualifications }}
                            </td>

                            <td style="padding:10px;">
                                {{ $doctor->available_hours }}
                            </td>

                            <td style="padding:10px;">
                                {{ $doctor->experience_years ?? '-' }}
                            </td>

                            <td style="padding:10px;">
                                {{ implode('، ', $doctor->services) }}
                            </td>

                            <td style="padding:10px;">
                                @can('manage doctors')
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                   style="background-color:#6c757d; color:#fff; padding:6px 12px;
                                          text-decoration:none; border-radius:4px; margin-right:4px;">
                                    Update
                                </a>
                                <a href="{{ route('admin.doctors.show', $doctor->id) }}"
                                   style="background-color:#6c757d; color:#fff; padding:10px 16px;
                                        text-decoration:none; border-radius:6px; display:inline-block; margin-bottom:20px;">
                                  View Appointments 
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background-color:#ff7a00; color:#fff; padding:6px 12px; border:none;
                                                   border-radius:4px; cursor:pointer;"
                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <a href="{{ url()->previous() }}"
           style="display:inline-block; margin-top:20px; padding:10px 20px;
                  background-color:#ff7a00; color:#fff; text-decoration:none;
                  border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            Go Back
        </a>

    </div>

    @else
        <div class="alert alert-danger">
            You do not have permission to manage doctors.
        </div>
    @endcan

</div>
@endsection