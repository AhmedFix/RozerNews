<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        
        return response()->api(CourseResource::collection($courses));

    }// end of index

    public function show($id){
        $courses = Course::with(['subjects'=>function($q){
            $q->select('name','description');
        }])->find($id);
        return  $courses;
    }

}//end of controller
