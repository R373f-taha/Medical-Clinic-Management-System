@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">
@can('manage doctors')
    <div style="max-width:800px; margin:auto;">

        <div style="margin-bottom:20px;">
            <h2 style="color:#ff7a00;">Edit Doctor Information</h2>
        </div>

        <div style="background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:25px;">

            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- User Select -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Doctor Name</label>
                    <select name="user_id" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $doctor->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Specialization -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Specialization</label>
                    <input type="text" name="specialization"
                           value="{{ old('specialization', $doctor->specialization) }}"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>
                    @error('specialization')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Qualifications -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Qualifications</label>
                    <textarea name="qualifications" rows="2"
                              style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>{{ old('qualifications', $doctor->qualifications) }}</textarea>
                    @error('qualifications')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Available Hours -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Available Hours (per week)</label>
                    <input type="number" name="available_hours"
                           value="{{ old('available_hours', $doctor->available_hours) }}"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>
                    @error('available_hours')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Years of Experience -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Years of Experience</label>
                    <input type="number" name="experience_years"
                           value="{{ old('experience_years', $doctor->experience_years) }}"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>
                    @error('experience_years')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Rate -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Current Rate</label>
                    <input type="number" step="0.1" name="Current_rate"
                           value="{{ old('Current_rate', $doctor->Current_rate) }}"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    @error('Current_rate')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Services -->
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Services</label>
                    <input type="text" name="services"
                           value="{{ old('services', implode('، ', $doctor->services ?? [])) }}"
                           style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;" required>
                    @error('services')
                        <div style="color:red; font-size:0.9em; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px;">
                    <button type="submit"
                            style="background-color:#ff7a00; color:#fff; padding:10px 20px; border:none; border-radius:6px; cursor:pointer;">
                        Update
                    </button>

                    <a href="{{ route('admin.doctors.index') }}"
                       style="background-color:#6c757d; color:#fff; padding:10px 20px; text-decoration:none; border-radius:6px;">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>
@endcan
</div>
@endsection
