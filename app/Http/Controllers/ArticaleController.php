<?php

namespace App\Http\Controllers;

use App\Models\Articale;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articales = Articale::latest()->paginate(10);
        
        return view('backend.articales.index', compact('articales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('backend.articales.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
      
            'title'          => 'required|string|max:255|unique:articales',
            'description'   => 'required|string|max:255',
            'poster'  => 'required|string',
            'video_url'    => 'required|string',
            'type'    => 'required|string',
            'vote'    => 'required|numeric',
            'vote_count'    => 'required|numeric',
            'category_id'    => 'required|exists:App\Models\Category,id',
            
        ]);

       $articale = Articale::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'poster'        => $request->poster,
            'video_url'     => $request->video_url,
            'type'          => $request->type,
            'vote'          => $request->vote,
            'vote_count'    => $request->vote_count,
            'category_id'    => $request->category_id
        ]);

        $category =Category::find($request->category_id);
        $category->articales()->attach($articale->id);

       
        return redirect()->route('articale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articale  $articale
     * @return \Illuminate\Http\Response
     */
    public function show(Articale $articale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articale  $articale
     * @return \Illuminate\Http\Response
     */
    public function edit(Articale $articale)
    {
        $categories = Category::latest()->get();

        return view('backend.articales.edit', compact('articale','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articale  $articale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articale $articale)
    {
        $request->validate([
            'title'          => 'required|string|max:255|unique:articales,title,'.$articale->id,
            'description'   => 'required|string|max:255',
            'poster'  => 'required|string',
            'video_url'    => 'required|string',
            'type'    => 'required|string',
            'vote'    => 'required|numeric',
            'vote_count'    => 'required|numeric',
            'category_id'    => 'required|unique:articales|exists:App\Models\Category,id',
        ]);

        $articale->update([
            'title'          => $request->title,
            'title'         => $request->title,
            'description'   => $request->description,
            'poster'        => $request->poster,
            'video_url'     => $request->video_url,
            'type'          => $request->type,
            'vote'          => $request->vote,
            'vote_count'    => $request->vote_count,
            'category_id'    => $request->category_id
        ]);

        $category =Category::find($request->category_id);
        $category->articales()->attach($articale->id);

        return redirect()->route('articale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articale  $articale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articale $articale)
    {
        $articale->delete();

        return back();
    }
}
