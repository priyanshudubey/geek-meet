<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Geek;
use App\Models\Profile;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 geeks with their profiles, posts, comments, and likes
        Geek::factory(10)
            ->create()
            ->each(function ($geek) {
                $geek->profile()->save(Profile::factory()->make());
                $posts = Post::factory(5)->create(['geek_id' => $geek->id]);
                foreach ($posts as $post) {
                    Comment::factory(3)->create([
                        'post_id' => $post->id, 'geek_id' => $geek->id,]);
                    Like::factory(2)->create([
                        'likeable_id' => $post->id, 
                        'likeable_type' => Post::class, 
                        'geek_id' => $geek->id,
                    ]);
                }
            });

        $this->call([
            GeekTableSeeder::class, PostTableSeeder::class, LikeTableSeeder::class, CommentTableSeeder::class,
            ProfileTableSeeder::class,
        ]);
    }
}
