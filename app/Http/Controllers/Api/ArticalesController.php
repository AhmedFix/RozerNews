<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ArticalesResource;
use App\Models\Articale;

class ArticalesController extends Controller
{
    public function index()
    {
        $articales = Articale::whenType(request()->type)
            ->whenSearch(request()->search)
            ->whenCategoryId(request()->category_id)
            ->with('categories')
            ->paginate(10);

        $data['articales'] = ArticalesResource::collection($articales)->response()->getData(true);

        return response()->api($data);

    }// end of index

    public function toggleFavorite()
    {
        auth()->user()->favoriteArticales()->toggle([request()->id]);

        return response()->api(null, 0, 'articale toggled successfully');

    }// end of toggleFavourite

    public function images(Articale $articale)
    {
        return response()->api(ImageResource::collection($articale->images));

    }// end of images

    public function relatedArticales(Articale $articale)
    {
        $articales = Articale::whereHas('categories', function ($q) use ($articale) {
            return $q->whereIn('name', $articale->categories()->pluck('name'));
        })
            ->with('categories')
            ->where('id', '!=', $articale->id)
            ->paginate(10);

        return response()->api(ArticalesResource::collection($articales));

    }// end of relatedArticales

}//end of controller
