<?php

namespace Database\Seeders;

use App\Models\FriendList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FriendList::factory(10)->create();
    }
}
