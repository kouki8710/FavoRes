<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Str;

class CommentTableSeeder extends Seeder
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
            Comment::insert([
                "user" => $user->id,
                "article" => $article->id,
                "content" => Str::random(10),
            ]);
        }
    }
}
