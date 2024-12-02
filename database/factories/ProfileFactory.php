<?php
namespace Database\Factories;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;
    public function definition()
    {
        return [
            'bio' => $this->faker->text(100),
            'location' => $this->faker->city,
            'profile_image' => $this->faker->imageUrl(640, 480, 'people'),
            'geek_id' => \App\Models\Geek::factory(), // Associate with a Geek
        ];
    }
}
