<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'password' => $this->faker->password(),
            'email' => $this->faker->unique()->safeEmail(),
            'remember_token'=> Str::random(10)
        ];
    }
}
