<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'administrator',
        ]);

        foreach (User::all() as $user) {
            Post::create([
                'author_id' => $user->id,
                'content' => Str::random(40),
                'header_image' => 'https://picsum.photos/id/237/200/300',
            ]);
        }
    }
}
