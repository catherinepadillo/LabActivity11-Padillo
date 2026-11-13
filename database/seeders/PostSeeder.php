<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::all();

        // 40 published posts
        Post::factory()
            ->count(40)
            ->sequence(fn ($seq) => [
                'author_id' => $authors->random()->id,
            ])
            ->create();

        // 10 unpublished drafts
        Post::factory()
            ->count(10)
            ->draft()
            ->sequence(fn ($seq) => [
                'author_id' => $authors->random()->id,
            ])
            ->create();

        // Retrieve the manually created Kagawad
        $kagawad = Author::where(
            'email',
            'kagawad.padillo@bulletin.test'
        )->firstOrFail();

        // Personalized pinned birthday post
        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Purok Padillo Clean-up Drive',
            'category' => 'Events',
            'body' => 'Join our Purok Padillo community clean-up drive. Residents are invited to help keep our streets and shared spaces clean. Please bring reusable gloves and cleaning supplies if available.',
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-05-04 08:00:00',
            'views' => 0,
        ]);
    }
}
