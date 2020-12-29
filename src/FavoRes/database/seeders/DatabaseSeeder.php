<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!\App\Models\User::all())
        {
            \App\Models\User::factory(10)->create();
        }
        $this->call([
            ArticleTableSeeder::class,
            CommentTableSeeder::class,
            StarTableSeeder::class,
        ]);
    }
}
