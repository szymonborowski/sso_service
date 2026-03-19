@extends('layouts.app')

@section('title', 'Autoryzacja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-950 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">Autoryzacja</h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ $client->name }}</strong> prosi o dostep do Twojego konta.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow dark:shadow-gray-900/50 dark:ring-1 dark:ring-gray-800">
            @if (count($scopes) > 0)
                <div class="mb-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Aplikacja uzyska dostep do:</p>
                    <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400">
                        @foreach ($scopes as $scope)
                            <li>{{ $scope->description }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex space-x-4">
                <form method="POST" action="{{ route('passport.authorizations.approve') }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 dark:focus:ring-offset-gray-900">
                        Zezwol
                    </button>
                </form>

                <form method="POST" action="{{ route('passport.authorizations.deny') }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="w-full py-2 px-4 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 dark:focus:ring-offset-gray-900">
                        Odmow
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
