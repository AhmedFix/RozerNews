<?php


namespace App\Http\Controllers;

use App\Models\Articale;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articales = Articale::latest()->get();
        
        return view('backend.categories.create', compact('articales'));
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
            'name'        => 'required|string|max:255|unique:categories',
             // 'image'     => 'required|numeric',
        ]);

        Category::create([
            'name'        => $request->name,
            // 'image'        => $request->image,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,'.$id,
            // 'image'     => 'required|numeric',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name'        => $request->name,
            // 'image'        => $request->image,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        $category->articales()->detach();
        $category->delete();

        return back();
    }

    /*
     * Assign Articales to Grade 
     * 
     * @return \Illuminate\Http\Response
     */
    public function assignArticale($categoryid)
    {
        $articales   = Articale::latest()->get();
        $assigned   = Category::with(['articales'])->findOrFail($categoryid);

        return view('backend.categories.assign-articale', compact('categoryid','articales','assigned'));
    }

    
    /*
     * Add Assigned Articale to Grade 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAssignedArticale(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->articale()->sync($request->selectedarticale);

        return redirect()->route('categories.index');
    }
}
