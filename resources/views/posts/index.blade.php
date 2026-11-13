@extends('layouts.app')

@section('title', 'Posts | Barangay Bulletin - Purok Padillo')

@section('content')

<h1 class="mb-5 text-2xl font-bold">
    Community Posts
</h1>

@if (session('status'))
    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
        {{ session('status') }}
    </div>
@endif

<!-- Search and category filtering -->
<form method="GET"
      action="{{ route('posts.index') }}"
      class="mb-7 grid gap-3 rounded-xl bg-white p-4 shadow-sm sm:grid-cols-[1fr_220px_auto]">

    @if (request()->filled('tag'))
        <input type="hidden" name="tag" value="{{ request('tag') }}">
    @endif

    <label class="sr-only" for="q">Search titles</label>

    <input
        id="q"
        type="search"
        name="q"
        value="{{ request('q') }}"
        placeholder="Search title"
        class="rounded-lg border border-slate-300 p-3"
    >

    <label class="sr-only" for="category">Category</label>

    <select id="category"
            name="category"
            class="rounded-lg border border-slate-300 p-3">

        <option value="">All categories</option>

        @foreach ($categories as $category)
            <option value="{{ $category }}"
                @selected(request('category') === $category)>
                {{ $category }}
            </option>
        @endforeach

    </select>

    <button class="rounded-lg bg-emerald-700 px-5 py-3 font-semibold text-white hover:bg-emerald-800">
        Filter
    </button>
</form>

@if (request()->filled('tag'))
    <div class="mb-5 flex items-center gap-3 text-sm">
        <span class="text-slate-600">
            Filtered by tag:
            <strong class="font-semibold text-emerald-800">{{ request('tag') }}</strong>
        </span>

        <a href="{{ route('posts.index', request()->except(['tag', 'page'])) }}"
           class="font-semibold text-slate-500 hover:text-slate-800 hover:underline">
            Clear tag
        </a>
    </div>
@endif

<!-- Responsive posts grid -->
<div class="grid gap-4 md:grid-cols-2">

    @forelse ($posts as $post)

        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="mb-3 flex flex-wrap items-center gap-2 text-xs font-semibold">

                <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-700">
                    {{ $post->category }}
                </span>

                @if ($post->is_pinned)
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-800">
                        Pinned
                    </span>
                @endif

            </div>

            <h2 class="text-lg font-bold">
                <a class="hover:text-emerald-700"
                   href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                By
                <a href="{{ route('authors.show', $post->author) }}"
                   class="font-semibold text-emerald-800 hover:underline">
                    {{ $post->author->name }}
                </a>
            </p>

            <p class="mt-2 text-sm text-slate-600">
                {{ \Illuminate\Support\Str::limit($post->body, 130) }}
            </p>

            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', array_merge(
                        request()->except('page'),
                        ['tag' => $tag->name]
                    )) }}"
                       class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-800 hover:bg-emerald-100">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>

            <div class="mt-4 flex justify-between gap-2 text-xs text-slate-500">
                <span>
                    {{ $post->published_at?->format('M d, Y') }}
                </span>

                <span>
                    {{ $post->comments_count }} comments · {{ $post->views }} views
                </span>
            </div>

        </article>

    @empty

        <p class="rounded-lg bg-white p-6 text-slate-600 md:col-span-2">
            No posts match your search.
        </p>

    @endforelse

</div>

<!-- Pagination -->
<div class="mt-7">
    {{ $posts->links() }}
</div>

<p class="mt-3 text-sm text-slate-600">
    Showing {{ $posts->firstItem() ?? 0 }}–{{ $posts->lastItem() ?? 0 }}
    of {{ $posts->total() }} posts
</p>

@endsection