<?php

namespace App\Http\Controllers;

use App\Plugin;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Filesystem\Filesystem;

class PluginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); #->except(['plugins', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plugins = Plugin::orderBy('name', 'asc')->with('categories')->get();
		return view('plugins.index', compact('plugins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('plugins.create')->with(compact('categories'));
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
            'name' =>       'required|max:191',
            'namespace' =>  'required|max:191',
            'identifier' => 'required|max:191',
            #'description' => 'required',
            'type' => 'required',

        ]);

        $plugin = new Plugin($request->all());
        $plugin->save();
        return redirect('/dashboard/plugins')->with('success', 'Plugin has been added');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plugin = Plugin::with('functions')->where('id', $id)->first();
        $categories = Category::all();
        return view('plugins.edit')->with(compact('plugin', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin)
    {
        $request->validate([
            'name' =>       'required|max:191',
            'namespace' =>  'required|max:191',
            'identifier' => 'required|max:191',
            'type' => 'required',

        ]);
        $plugin->fill($request->all());
        $plugin->save();
        return redirect('/dashboard/plugins#' . $plugin->id)->with('success', 'Plugin has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        $plugin->delete();
        return redirect('/dashboard/plugins')->with('success', 'Plugin '.$plugin->name.' has been deleted');
    }

    /**
     * export all plugins to json
     */
    public function export()
    {
        if(Auth::user()->id != 1) {
            return "Sorry, only for Admins";
        }

        # too lazy for select
        $plugins = Plugin::with('functions.categories')->with('categories')->get()
            ->makeHidden(['categories_id', 'is_collection', 'id', 'categories', 'dependencies', 'releases', 'version', 'version_published']);

        # some plugins share the same namespace
        $dupes = $plugins->groupBy('namespace')->filter(function ($value, $key) {
            return $value->count() > 1;
        });

        $file = new Filesystem;
        $file->cleanDirectory(storage_path().'/app/vsdb-json/json/');

        foreach($plugins as $plugin) {

            $plugin->category = $plugin->categories['name']; # TODO I don't like that category is at the bottom of the list.
            $id = $plugin->id;

            foreach($plugin->functions as $pfunc) {
                $pfunc->category = $pfunc->categories['name'];
                $pfunc->makeHidden(['plugin_id', 'categories_id', 'id', 'categories']);
            }

            #return $plugin;
            if(isset($dupes[$plugin->namespace])) { # rename duplicates to "namespace_ID.json"
                $filepath = 'vsdb-json/json/'.$plugin->namespace.'_'.$id.'.json';
            } else {
                $filepath = 'vsdb-json/json/'.$plugin->namespace.'.json';
            }
            Storage::put($filepath, $plugin->toJson(JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES));

        }
        return "done";
    }

}
