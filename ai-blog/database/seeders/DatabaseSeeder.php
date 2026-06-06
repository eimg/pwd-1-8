<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $alice = User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);

        $bob = User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
        ]);

        $categories = collect([
            'Technology',
            'Lifestyle',
            'Travel',
            'Food',
            'Health',
        ])->map(fn (string $name) => Category::create(['name' => $name]));

        $users = collect([$alice, $bob]);

        $posts = collect(range(1, 20))->map(function (int $i) use ($users, $categories) {
            return Post::create([
                'title' => fake()->sentence(6),
                'body' => fake()->paragraphs(4, true),
                'feature_image' => "https://picsum.photos/seed/post{$i}/800/400",
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
            ]);
        });

        collect(range(1, 40))->each(function () use ($users, $posts) {
            Comment::create([
                'content' => fake()->sentence(12),
                'post_id' => $posts->random()->id,
                'user_id' => $users->random()->id,
            ]);
        });
    }
}
