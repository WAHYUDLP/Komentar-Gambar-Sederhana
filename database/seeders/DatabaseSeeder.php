<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
 public function run(): void
    {
        // Buat user test
        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        // Buat komentar test
        Comment::create([
            'user_id' => $user1->id,
            'content' => 'Gambar yang sangat indah! Saya suka dengan komposisi warnanya.',
        ]);

        Comment::create([
            'user_id' => $user2->id,
            'content' => 'Wow, pencahayaannya bagus sekali. Foto yang profesional!',
        ]);
    }
}
