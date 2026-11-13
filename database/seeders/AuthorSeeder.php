<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'name' => 'Catherine Padillo',
            'position' => 'Kagawad',
            'email' => 'kagawad.padillo@bulletin.test',
        ]);

        Author::factory()->count(4)->create();
    }
}
