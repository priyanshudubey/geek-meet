<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Geek;

class GeekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 geeks using the factory
        Geek::factory()->count(10)->create();
    }
}
