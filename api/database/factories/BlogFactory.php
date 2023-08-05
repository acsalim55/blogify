<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{

    
    public function definition()
    {
        return [
            'title' => $this->faker->text(100),
            'details' => $this->faker->sentence(10),
            'content' => $this->faker->paragraph(1000),
            'user_id' => DB::connection('mysql')->table('users')->inRandomOrder()->value('id')
        ];
    }
}
