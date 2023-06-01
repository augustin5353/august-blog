<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        $user1 = User::find(12);
        $user2 = User::find(14);
        $musique = Category::find(6);
        $prog = Category::find(17);



        Article::factory()
        ->count(6)
        ->for($user1)
        ->for($musique)
        ->create();

        Article::factory()
        ->count(6)
        ->for($user2)
        ->for($prog)
        ->create();
            

        //\App\Models\Category::factory(5)->create();

        /* User::factory()->create([
             'name' => 'Gustino',
             'email' => 'gustino@gmail.Com',
             'password' => Hash::make('00000000'),
         ]); */
    }
}
