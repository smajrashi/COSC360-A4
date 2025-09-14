<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
  public function run()
    {
        Post::truncate();

        $admin = User::where('is_admin', true)->first();
        $categories = Category::all();

        // create 10 posts assigned to admin and random category
        for ($i=0; $i<10; $i++) {
            Post::factory()->create([
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}


