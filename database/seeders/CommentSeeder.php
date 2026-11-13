<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $posts = Post::where('is_published', true)
            ->where('is_pinned', false)
            ->get();

        foreach ($posts as $post) {
            $count = rand(0, 5);

            for ($i = 0; $i < $count; $i++) {
                Comment::factory()
                    ->for($post)
                    ->for($users->random())
                    ->create();
            }
        }

        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();

        $lola = User::where(
            'email',
            'lola.padillo@bulletin.test'
        )->firstOrFail();

        Comment::factory()
            ->for($pinnedPost)
            ->for($lola)
            ->create();

        for ($i = 0; $i < 2; $i++) {
            Comment::factory()
                ->for($pinnedPost)
                ->for($users->random())
                ->create();
        }
    }
}
