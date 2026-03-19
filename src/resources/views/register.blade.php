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

            <form method="POST" action="{{ url('/register')  }}" class="mt-8 space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow dark:shadow-gray-900/50 dark:ring-1 dark:ring-gray-800">
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
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="appearance-none rounded relative block w-full px-3 py-2 border @error('password') border-red-500 dark:border-red-400 @else border-gray-300 dark:border-gray-700 @enderror placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="{{ __('auth.password') }}">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="sr-only">{{ __('auth.confirm_password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-sky-700 dark:focus:ring-sky-500 focus:border-sky-700 dark:focus:border-sky-500 sm:text-sm"
                               placeholder="{{ __('auth.confirm_password') }}">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 dark:focus:ring-offset-gray-900">
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
