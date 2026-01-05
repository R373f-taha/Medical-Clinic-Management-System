@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto;">

       
        <div style="margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Add New Doctor
            </h2>
        </div>


        <div style="background:#ffffff; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1);
                    padding:25px;">

            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf

               
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">User</label>
                    <select name="user_id"
                            style="width:100%; padding:10px; border-radius:6px;
                                   border:1px solid #ccc;" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Specialization</label>
                    <input type="text" name="specialization"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

               
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Qualifications</label>
                    <textarea name="qualifications" rows="2"
                              style="width:100%; padding:10px; border-radius:6px;
                                     border:1px solid #ccc;" required></textarea>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Available Hours</label>
                    <input type="number" name="available_hours" value="40"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

         
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Years of Experience</label>
                    <input type="number" name="experience_years" value="0"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">Rating</label>
                    <input type="number" step="0.1" min="0" max="5"
                           name="current_rate" value="0"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit"
                            style="background-color:#ff7a00; color:#fff;
                                   padding:10px 20px; border:none;
                                   border-radius:6px; cursor:pointer;">
                        Save
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