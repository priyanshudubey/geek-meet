<?php
namespace Database\Factories;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => \App\Models\Post::factory(), // Associate with a Post
            'geek_id' => \App\Models\Geek::factory(), // Associate with a Geek
            'content' => $this->faker->sentence,
        ];
    }
}
