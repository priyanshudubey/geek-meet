<?php
namespace Database\Factories;
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Geek;
use App\Models\Post;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    protected $model = Like::class;
    public function definition(): array
    {
        $post = Post::inRandomOrder()->first(); // Get a random Post
        return [
            'geek_id' => Geek::factory(), // Associate with a Geek
        ];
    }
}
