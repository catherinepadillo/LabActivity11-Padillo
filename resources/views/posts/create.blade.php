@extends('layouts.app')

@section('title', 'Create Post | Barangay Bulletin - Purok Padillo')

@section('content')

<a href="{{ route('posts.index') }}"
   class="text-sm font-semibold text-emerald-800 hover:underline">
    ← Back to posts
</a>

<div class="mt-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">
    <h1 class="text-2xl font-bold text-slate-900">Create Bulletin Post</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-slate-700">
                Title
            </label>
            <input
                id="title"
                name="title"
                type="text"
                value="{{ old('title') }}"
                class="mt-1 w-full rounded-lg border border-slate-300 p-2.5 text-slate-800 focus:border-emerald-700 focus:outline-none"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-slate-700">
                Content
            </label>
            <textarea
                id="body"
                name="body"
                rows="6"
                class="mt-1 w-full rounded-lg border border-slate-300 p-2.5 text-slate-800 focus:border-emerald-700 focus:outline-none"
            >{{ old('body') }}</textarea>

            @error('body')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-slate-700">
                Category
            </label>
            <select
                id="category"
                name="category"
                class="mt-1 w-full rounded-lg border border-slate-300 bg-white p-2.5 text-slate-800 focus:border-emerald-700 focus:outline-none"
            >
                <option value="">Select category</option>

                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(old('category') === $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <fieldset>
            <legend class="text-sm font-semibold text-slate-700">Tags</legend>

            <div class="mt-2 space-y-2">
                @foreach ($tags as $tag)
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input
                            type="checkbox"
                            name="tags[]"
                            value="{{ $tag->id }}"
                            class="rounded border-slate-300 text-emerald-800 focus:ring-emerald-700"
                            @checked(in_array((string) $tag->id, array_map('strval', old('tags', []))))
                        >
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>

            @error('tags')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @foreach ($errors->get('tags.*') as $message)
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @endforeach
        </fieldset>

        <div>
            <input type="hidden" name="is_published" value="0">

            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    class="rounded border-slate-300 text-emerald-800 focus:ring-emerald-700"
                    @checked(old('is_published', '1'))
                >
                <span>Publish immediately</span>
            </label>

            @error('is_published')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="rounded-lg bg-emerald-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-900"
        >
            Save Post
        </button>
    </form>
</div>

@endsection