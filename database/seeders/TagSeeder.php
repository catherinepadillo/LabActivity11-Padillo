<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Purok Padillo',
            'Urgent',
            'Libre',
            'Schedule',
            'Community',
        ];

        foreach ($names as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }

        $tags = Tag::all();

        $posts = Post::where('is_pinned', false)->get();

        foreach ($posts as $post) {
            $randomTags = $tags->random(rand(1, 3))->pluck('id')->all();
            $post->tags()->sync($randomTags);
        }

        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();

        $pinnedPost->tags()->sync(
            Tag::whereIn('name', [
                'Purok Padillo',
                'Urgent',
            ])->pluck('id')->all()
        );
    }
}
