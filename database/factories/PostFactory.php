<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{ protected $model = Post::class;
    public function definition()
    {
        return [
            'title' => $this->faker->text(40),
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(), // will be overridden in seeder to admin user
            'category_id' => Category::factory(),
            'is_active' => $this->faker->randomElement(['Yes','No']),
        ];
    }
}