<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        if ($user){
            Article::insert([
                "title" => "testtest",
                "content" => "test",
                "address" => "test",
                "user" => $user->id,
            ]);
        }else{
            print("Userが存在しません\n");
        }
    }
}
