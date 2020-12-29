<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Star;
use App\Models\User;
use App\Models\Article;

class StarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $article = Article::find(1);
        if ($user && $article)
        {
            Star::insert([
                "user" => $user->id,
                "article" => $article->id,
                "num_star" => "1",
            ]);
        }
    }
}
