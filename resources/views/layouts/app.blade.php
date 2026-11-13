<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Barangay Bulletin - Purok Padillo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    <header class="bg-emerald-800 text-white shadow">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-5 sm:px-6">
            <div>
                <a href="{{ route('posts.index') }}"
                   class="text-xl font-bold">
                    Barangay Bulletin - Purok Padillo
                </a>

                <p class="mt-1 text-sm text-emerald-100">
                    Updates from our community
                </p>
            </div>

            <nav class="flex flex-wrap items-center gap-4 text-sm font-semibold">
                @guest
                    <a href="{{ route('login') }}"
                       class="rounded-lg bg-white px-4 py-2 text-emerald-900 hover:bg-emerald-50">
                        Login
                    </a>
                @endguest

                @auth
                    @if (auth()->user()->author()->exists())
                        <a href="{{ route('posts.create') }}"
                           class="rounded-lg bg-emerald-700 px-4 py-2 text-white hover:bg-emerald-600">
                            New post
                        </a>
                    @endif

                    <span class="font-normal text-emerald-100">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="rounded-lg bg-white px-4 py-2 text-emerald-900 hover:bg-emerald-50">
                            Logout
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 py-5 text-center text-sm text-slate-500">
        Barangay Matina Crossing · Community Bulletin
    </footer>

</body>
</html>
