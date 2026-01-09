@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto;">

       
        <div style="margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Edit Doctor Information
            </h2>
        </div>

        <div style="background:#ffffff; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1);
                    padding:25px;">

            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

          
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">doctor name</label>
                    <select name="user_id"
                            style="width:100%; padding:10px; border-radius:6px;
                                   border:1px solid #ccc;" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $doctor->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Specialization</label>
                    <input type="text" name="specialization"
                           value="{{ old('specialization', $doctor->specialization) }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

               
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Qualifications</label>
                    <textarea name="qualifications" rows="2"
                              style="width:100%; padding:10px; border-radius:6px;
                                     border:1px solid #ccc;" required>{{ old('qualifications', $doctor->qualifications) }}</textarea>
                </div>

               
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Available Hours (per week)</label>
                    <input type="number" name="available_hours"
                           value="{{ old('available_hours', $doctor->available_hours) }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Years of Experience</label>
                    <input type="number" name="experience_years"
                           value="{{ old('experience_years', $doctor->experience_years) }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

        
                <div style="display:flex; gap:10px;">
                    <button type="submit"
                            style="background-color:#ff7a00; color:#fff;
                                   padding:10px 20px; border:none;
                                   border-radius:6px; cursor:pointer;">
                        Update
                    </button>

                    <a href="{{ route('doctors.index') }}"
                       style="background-color:#6c757d; color:#fff;
                              padding:10px 20px; text-decoration:none;
                              border-radius:6px;">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection