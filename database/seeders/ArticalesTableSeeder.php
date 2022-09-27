<?php

namespace Database\Seeders;

use App\Models\Articale;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArticalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $articales = [
            [
            'title' => 'test 1',
            'description' => 'test description',
            'poster' => 'image url',
            'video_url' => 'video url',
            'type' => 'image',
            'vote' => 4.5,
            'vote_count' => 20,
            'category_id' => 1
        ],
           
        ];

        foreach ($articales as $articale) {

            $articale= Articale::create($articale);

            $category =Category::find($articale['category_id']);
            $category->articales()->attach($articale['id']);

          
    
        }//end of for each


    }//end of run

}//end of seeder
