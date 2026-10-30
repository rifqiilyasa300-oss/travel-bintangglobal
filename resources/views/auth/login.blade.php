<x-guest-layout>


    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-bold text-[#2C4E58] uppercase text-[10px] tracking-widest" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="font-bold text-[#2C4E58] uppercase text-[10px] tracking-widest" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#2C4E58] shadow-sm focus:ring-[#C5A367]" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full bg-[#2C4E58] hover:bg-black text-white font-black py-3 rounded-xl uppercase text-[11px] tracking-[0.2em] transition shadow-lg">
                {{ __('Log in') }}
            </button>

            <div class="flex items-center justify-between mt-2">
                @if (Route::has('password.request'))
                    <a class="underline text-[10px] font-bold text-gray-400 hover:text-[#2C4E58] uppercase tracking-widest" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <a href="{{ route('register') }}" class="text-[10px] font-black text-[#C5A367] hover:text-[#2C4E58] uppercase tracking-widest no-underline">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
