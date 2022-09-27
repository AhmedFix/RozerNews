<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articale extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'description', 'poster', 'video_url', 'vote',
        'vote_count', 'type','category_id'
    ];

    protected $appends = ['poster_path'];

    // protected $casts = [
    //     'release_date' => 'date',
    // ];

    //attr
    public function getPosterPathAttribute()
    {
        if ($this->poster) {
            return asset('uploads/articales_images/' . $this->poster);
        }

        return asset('uploads/articales_images/default.png');
        
    }// end of getPosterPathAttribute


    //scope


    public function scopeWhenCategoryId($query, $categoryId)
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {

            return $q->whereHas('categories', function ($qu) use ($categoryId) {

                return $qu->where('categories.id', $categoryId);

            });

        });

    }// end of scopeWhenCategoryId

    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {

            if ($type == 'popular') {
                return $q->where('type', null);
            }

            return $q->where('type', $type);

        });

    }// end of scopeWhenType

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {

            return $q->where('title', 'like', '%' . $search . '%');

        });

    }// end of scopeWhenSearch

    //rel
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'articale_category');

    }// end of categories


    public function images()
    {
        return $this->hasMany(Image::class);

    }// end of images

    public function favoriteByUsers()
    {
        return $this->belongsToMany(User::class, 'user_favorite_articale', 'articale_id', 'user_id');

    }// end of favouriteByUsers

    //fun
    public function hasPoster()
    {
        return $this->poster != null;

    }// end of hasPoster


}//end of model
