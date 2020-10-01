<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = factory(Category::class, 5)->create();
        $categories->each(function($category){
            factory(\App\Models\Post::class, 3)->create([
                'category_id' => $category->id,
            ]);
        });
    }
}
