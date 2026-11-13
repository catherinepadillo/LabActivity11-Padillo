
@extends('layouts.app')

@section('title', $post->title . ' | Barangay Bulletin - Purok Padillo')

@section('content')

<a href="{{ route('posts.index') }}"
   class="text-sm font-semibold text-emerald-800 hover:underline">
    ← Back to posts
</a>

@if (session('status'))
    <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
        {{ session('status') }}
    </div>
@endif

<article class="mt-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">

    <div class="flex flex-wrap gap-2 text-sm">

        <span class="rounded-full bg-slate-100 px-3 py-1">
            {{ $post->category }}
        </span>

        @if ($post->is_pinned)
            <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-800">
                Pinned
            </span>
        @endif

        @foreach ($post->tags as $tag)
            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
               class="rounded-full bg-emerald-50 px-3 py-1 text-emerald-800 hover:bg-emerald-100">
                {{ $tag->name }}
            </a>
        @endforeach

    </div>

    <h1 class="mt-4 text-3xl font-bold">
        {{ $post->title }}
    </h1>

    <p class="mt-3 text-sm text-slate-500">
        By
        <a href="{{ route('authors.show', $post->author) }}"
           class="font-semibold text-emerald-800 hover:underline">
            {{ $post->author->name }}
        </a>
        · Published {{ $post->published_at?->format('F d, Y') }}
        · {{ $post->views }} views
    </p>

    <div class="mt-8 whitespace-pre-line leading-7 text-slate-700">
        {{ $post->body }}
    </div>

</article>

<section class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">
    <h2 class="text-xl font-bold text-slate-900">
        Comments ({{ $post->comments->count() }})
    </h2>

    @if ($errors->any())
        <div class="my-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @auth
        <form action="{{ route('comments.store', $post) }}" method="POST" class="my-5">
            @csrf

            <label for="comment-body" class="block text-sm font-medium text-slate-700">
                Your comment
            </label>

            <textarea
                id="comment-body"
                name="body"
                rows="3"
                class="mt-1 w-full rounded-lg border border-slate-300 p-3 text-slate-800 focus:border-emerald-700 focus:outline-none"
            >{{ old('body') }}</textarea>

            @error('body')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button
                type="submit"
                class="mt-3 rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-900"
            >
                Post Comment
            </button>
        </form>
    @else
        <p class="my-4 text-sm text-slate-600">
            <a href="{{ route('login') }}" class="font-semibold text-emerald-800 hover:underline">
                Sign in to comment
            </a>
        </p>
    @endauth

    <div class="mt-6 divide-y divide-slate-200">
        @forelse ($post->comments->sortByDesc('created_at') as $comment)
            <div class="py-4">
                <p class="font-semibold text-slate-900">
                    {{ $comment->user->name }}
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $comment->body }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    {{ $comment->created_at->format('M d, Y') }}
                </p>
            </div>
        @empty
            <p class="py-4 text-sm text-slate-500">No comments yet.</p>
        @endforelse
    </div>
</section>

@endsection