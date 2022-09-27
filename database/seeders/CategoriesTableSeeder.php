<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Politics'],
            ['name' => 'Sports'],
            ['name' => 'Fashions']
        ];

        foreach ($categories as $category) {

            Category::create($category);

        }//end of for each


    }//end of run

}//end of seeder
