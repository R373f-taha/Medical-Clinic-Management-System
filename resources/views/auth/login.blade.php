<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative bg-cover bg-center"
         style="background-image: url('/images/logo1.png');">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Login Card -->
        <div class="relative w-full max-w-md p-8 rounded-2xl
                    bg-white/20 backdrop-blur-xl
                    border border-white/30
                    shadow-2xl">

            <!-- Version -->
            <div class="absolute -top-4 right-6 bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-semibold shadow">
                V9 X2
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

            <h1 class="text-2xl font-semibold text-white text-center mb-6">
                Clinic System Login
            </h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email"
                        class="text-white/80" />
                    <x-text-input id="email"
                        class="mt-1 block w-full bg-white/80 focus:bg-white"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" value="Password"
                        class="text-white/80" />
                    <x-text-input id="password"
                        class="mt-1 block w-full bg-white/80 focus:bg-white"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                </div>

                <!-- Remember -->
                <div class="mt-4 flex items-center justify-between">
                    <label class="inline-flex items-center text-sm text-white/80">
                        <input type="checkbox"
                               class="rounded border-white/30 bg-white/60 text-orange-500 focus:ring-orange-500"
                               name="remember">
                        <span class="ms-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-white/80 hover:text-white underline"
                           href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-3 rounded-lg
                               bg-orange-500 hover:bg-orange-600
                               text-white font-semibold
                               transition shadow-lg">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
