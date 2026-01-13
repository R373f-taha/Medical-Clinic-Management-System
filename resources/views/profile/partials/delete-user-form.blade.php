<section>
    <header style="margin-bottom:15px;">
        <h3 style="color:#dc3545; margin-bottom:8px;">
            Delete Account
        </h3>

        <p style="font-size:14px; color:#6c757d;">
            Once your account is deleted, all of its data will be permanently removed.
        </p>
    </header>

    <form method="POST"
          action="{{ route('profile.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        @csrf
        @method('DELETE')

        <button type="submit"
            style="
                background:#dc3545;
                color:#fff;
                padding:10px 18px;
                border:none;
                border-radius:6px;
                cursor:pointer;
            ">
            Delete Account
        </button>
    </form>
</section>
