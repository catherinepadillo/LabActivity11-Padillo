
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-12">
    <div class="mx-auto max-w-md rounded-xl bg-white p-8 shadow-md">

        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">
                Barangay Bulletin
            </h1>

            <p class="mt-2 text-gray-600">
                Purok Padillo
            </p>

            <p class="mt-4 text-sm text-gray-500">
                Sign in to your account
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST"
              class="space-y-5">
            @csrf

            <div>
                <label for="email"
                       class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="mt-1 w-full rounded-lg border border-gray-300
                           px-3 py-2 focus:border-blue-500
                           focus:outline-none"
                    placeholder="Enter your email"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password"
                       class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="mt-1 w-full rounded-lg border border-gray-300
                           px-3 py-2 focus:border-blue-500
                           focus:outline-none"
                    placeholder="Enter your password"
                >

                @error('password')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-700 px-4 py-2
                       font-semibold text-white hover:bg-blue-800"
            >
                Sign In
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('posts.index') }}"
               class="text-sm text-blue-700 hover:underline">
                Back to Bulletin
            </a>
        </div>
    </div>
</div>
@endsection
