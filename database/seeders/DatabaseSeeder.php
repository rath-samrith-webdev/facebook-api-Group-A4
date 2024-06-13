<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Like;
use App\Models\React;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call(PostSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ReactSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(ReplySeeder::class);
    }
}
