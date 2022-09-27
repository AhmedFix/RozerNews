<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    //attr
    protected $guarded = [];
    //scope

    //rel
    public function articales()
    {
        return $this->belongsToMany(Articale::class, 'articale_category');

    }// end of articales
    public function articale()
    {
        return $this->belongsToMany(Articale::class);
    }// end of Subjects
    //fun

}//end of model
