@extends('doctor.layouts.app')

@section('content')
<div style="background:#f4f6f8; min-height:100vh; padding:40px 20px;">

    <div style="max-width:1000px; margin:auto;">

        <!-- Page Header -->
        <div style="margin-bottom:40px;">
            <h2 style="color:#ff7a00; margin-bottom:8px;">
                Profile Settings
            </h2>
            <p style="color:#6c757d; margin:0;">
                Manage your personal information, password, and account settings
            </p>
        </div>

        <!-- Update Profile -->
        <div style="
            background:#ffffff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            margin-bottom:30px;
        ">
            <h4 style="margin-bottom:20px; color:#343a40;">
                👤 Personal Information
            </h4>

            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div style="
            background:#ffffff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            margin-bottom:30px;
        ">
            <h4 style="margin-bottom:20px; color:#343a40;">
                🔒 Change Password
            </h4>

            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div style="
            background:#fff5f5;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            border:1px solid #f5c6cb;
        ">
            <h4 style="margin-bottom:15px; color:#dc3545;">
                ⚠️ Delete Account
            </h4>

            <p style="color:#6c757d; font-size:14px; margin-bottom:20px;">
                Once your account is deleted, all of its resources and data will be permanently removed.
            </p>

            @include('profile.partials.delete-user-form')
        </div>

    </div>

</div>
@endsection
