<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Blog;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        User::factory(100)->create();
        Blog::factory(200)->create();
    }
}
