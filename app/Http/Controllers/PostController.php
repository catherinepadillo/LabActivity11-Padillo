<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Start with published posts and eager-load relationships
        $query = Post::query()
            ->where('is_published', true)
            ->with(['author', 'tags'])
            ->withCount('comments');

        // Optional title search
        if ($request->filled('q')) {
            $query->where(
                'title',
                'like',
                '%' . $request->input('q') . '%'
            );
        }

        // Optional category filter
        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->input('category')
            );
        }

        // Optional tag filter
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tagQuery) use ($request) {
                $tagQuery->where(
                    'name',
                    $request->input('tag')
                );
            });
        }

        // Pinned posts first, then newest
        $posts = $query
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7)
            ->withQueryString();

        $categories = [
            'Announcement',
            'Health',
            'Peace & Order',
            'Ayuda',
            'Events',
        ];

        return view('posts.index', compact(
            'posts',
            'categories'
        ));
    }

    public function create()
    {
        abort_unless(auth()->user()->author()->exists(), 403);

        $tags = Tag::orderBy('name')->get();

        $categories = [
            'Announcement',
            'Health',
            'Peace & Order',
            'Ayuda',
            'Events',
        ];

        return view('posts.create', compact('tags', 'categories'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $author = $request->user()->author()->firstOrFail();

        $published = (bool) ($data['is_published'] ?? false);

        $post = $author->posts()->create([
            'title' => $data['title'],
            'body' => $data['body'],
            'category' => $data['category'],
            'is_published' => $published,
            'is_pinned' => false,
            'published_at' => $published ? now() : null,
            'views' => 0,
        ]);

        $post->tags()->sync($data['tags']);

        return redirect()
            ->route('posts.index')
            ->with('status', $published ? 'Post published.' : 'Draft saved.');
    }

    public function show($id)
    {
        // Find post or return 404
        $post = Post::findOrFail($id);

        // Prevent drafts from being viewed
        abort_unless($post->is_published, 404);

        // Increment the view counter
        $post->increment('views');

        // Eager-load author, tags, and comments with their users
        $post->load([
            'author',
            'tags',
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}
