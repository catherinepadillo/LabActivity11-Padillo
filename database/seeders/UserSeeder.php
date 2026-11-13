<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kagawad = User::updateOrCreate(
            ['email' => 'kagawad.padillo@bulletin.test'],
            [
                'name' => 'Catherine Padillo',
                'password' => Hash::make('bulletin2026'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'lola.padillo@bulletin.test'],
            [
                'name' => 'Lola Padillo',
                'password' => Hash::make('bulletin2026'),
            ]
        );

        $author = Author::where('email', 'kagawad.padillo@bulletin.test')->firstOrFail();

        $author->update([
            'user_id' => $kagawad->id,
        ]);

        User::factory()->count(8)->create();
    }
}