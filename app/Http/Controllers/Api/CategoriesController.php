<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return response()->api(CategoriesResource::collection($categories));

    }// end of index

    public function show($id){
        $categories = Category::with(['articales'=>function($q){
            $q->select('title','description','poster','video_url','type','vote','vote_count','category_id');
        }])->find($id);
        return  $categories;
    }

}//end of controller
