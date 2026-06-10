<!-- resources/views/register.blade.php -->
@extends('layouts.app')

@section('title', __('auth.register'))

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-950 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ __('auth.register_heading') }}</h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">{{ __('auth.have_account') }} <a href="{{ route('login') }}" class="font-medium text-sky-600 dark:text-sky-400 hover:text-sky-500 dark:hover:text-sky-300">{{ __('auth.login_link') }}</a></p>
            </div>

            <form method="POST" action="{{ url('/register')  }}" class="mt-8 space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow dark:shadow-gray-900/50 dark:ring-1 dark:ring-gray-800"
                  x-data="{ showPw: false, showPw2: false, pw: '', pw2: '', pwEdited: false }">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="name" class="sr-only">{{ __('auth.username') }}</label>
                        <input id="name" name="name" type="text" required autocomplete="name"
                               class="appearance-none rounded relative block w-full px-3 py-2 border @error('name') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="{{ __('auth.username') }}" value="{{ old('name') }}">
                        @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required autocomplete="email"
                               class="appearance-none rounded relative block w-full px-3 py-2 border @error('email') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sr-only">{{ __('auth.password') }}</label>
                        <div class="relative">
                            <input id="password" name="password" :type="showPw ? 'text' : 'password'" required autocomplete="new-password"
                                   x-model="pw" @input="pwEdited = true"
                                   class="appearance-none rounded relative block w-full px-3 py-2 pr-10 border @error('password') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                                   placeholder="{{ __('auth.password') }}">
                            <button type="button" @click="showPw = !showPw" tabindex="-1"
                                    :aria-label="showPw ? @js(__('auth.hide_password')) : @js(__('auth.show_password'))"
                                    :title="showPw ? @js(__('auth.hide_password')) : @js(__('auth.show_password'))"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password')
                        <p x-show="!pwEdited" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="sr-only">{{ __('auth.confirm_password') }}</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" :type="showPw2 ? 'text' : 'password'" required autocomplete="new-password"
                                   x-model="pw2" @input="pwEdited = true"
                                   class="appearance-none rounded relative block w-full px-3 py-2 pr-10 border placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                                   :class="pw2.length > 0 && pw !== pw2 ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700'"
                                   placeholder="{{ __('auth.confirm_password') }}">
                            <button type="button" @click="showPw2 = !showPw2" tabindex="-1"
                                    :aria-label="showPw2 ? @js(__('auth.hide_password')) : @js(__('auth.show_password'))"
                                    :title="showPw2 ? @js(__('auth.hide_password')) : @js(__('auth.show_password'))"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg x-show="!showPw2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPw2" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <p x-show="pw2.length > 0 && pw !== pw2" style="display:none" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ __('auth.passwords_no_match') }}</p>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            :disabled="pw.length > 0 && pw2.length > 0 && pw !== pw2"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 dark:focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('auth.sign_up') }}
                    </button>
                </div>

                @if(session('status'))
                    <p class="text-sm text-sky-600 dark:text-sky-400">{{ session('status') }}</p>
                @endif

            </form>
        </div>
    </div>
@endsection
