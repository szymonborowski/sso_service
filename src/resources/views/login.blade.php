<!-- resources/views/login.blade.php -->
@extends('layouts.app')

@section('title', __('auth.login'))

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-950 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ __('auth.login_heading') }}</h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">{{ __('auth.no_account') }} <a href="{{ route('register') }}" class="font-medium text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-300">{{ __('auth.register_link') }}</a></p>
            </div>

            <form method="POST" action="{{ url('/login')  }}" class="mt-8 space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow dark:shadow-gray-900/50 dark:ring-1 dark:ring-gray-800">
                @csrf

                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none rounded relative block w-full px-3 py-2 border @error('email') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sr-only">{{ __('auth.password') }}</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none rounded relative block w-full px-3 py-2 border @error('password') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="{{ __('auth.password') }}">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-sky-600 focus:ring-sky-700 border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">{{ __('auth.remember_me') }}</label>
                    </div>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a class="font-medium text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-300" href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                        @endif
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 dark:focus:ring-offset-gray-900">
                        {{ __('auth.sign_in') }}
                    </button>
                </div>

                @if(session('status'))
                    <p class="text-sm text-sky-600 dark:text-sky-400">{{ session('status') }}</p>
                @endif

            </form>
        </div>
    </div>
@endsection
