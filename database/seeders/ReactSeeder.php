<?php

namespace Database\Seeders;

use App\Models\React;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        React::create([
            'react_name' => 'Like'
        ]);
        React::create([
            'react_name' => 'Love'
        ]);
        React::create([
            'react_name' => 'Haha'
        ]);
        React::create([
            'react_name' => 'Wow'
        ]);
        React::create([
            'react_name' => 'Sad'
        ]);
        React::create([
            'react_name' => 'Angry'
        ]);
    }
}
