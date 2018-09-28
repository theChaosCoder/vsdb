<?php

namespace App\Http\Controllers;
use App\Plugin;
use App\PluginFunction;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        /*$categories = Cache::remember('categories', 1, function () {
            return Category::orderBy('name', 'asc')->get();
        });*/
		return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'name' => 'unique:categories|required|max:50',
        ]);

        $category = new Category;
        $category->name = $request->input('name');

        $category->save();
        return redirect('/dashboard/categories')->with('success', 'Category has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'unique:categories|required|max:50',
        ]);

        $category->name = $request->input('name');

        $category->save();
        return redirect('/dashboard/categories')->with('success', 'Category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $plugin = Plugin::select('id')->where('categories_id', $category->id)->get();
        $plugin_function = PluginFunction::select('id')->where('categories_id', $category->id)->get();
        if(count($plugin) || count($plugin_function)) {
            return back()->withErrors(['This Category is in use!']);#return redirect('/categories')->with('error', 'Category is in use!');
        }

        $category->delete();
        return redirect('/dashboard/categories')->with('success', 'Category has been deleted');
    }
}
