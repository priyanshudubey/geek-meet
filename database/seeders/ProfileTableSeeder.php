<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\Geek;
class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::factory()->count(50)->create();
    }
}
