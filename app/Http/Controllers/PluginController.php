<?php

namespace App\Http\Controllers;

use App\Plugin;
use App\Category;
use App\Vsrepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        # check if something has changed with git diff
        $check = shell_exec("cd " . storage_path() . "/app/vsdb-json && git diff");
        return "<h2>done</h2> <pre><br>" . $check;
    }


    /**
     * Sync releses, vserion, published, dependencies from vspackages.json (storage folder)
     */
    public function sync()
    {
        if(Auth::user()->id != 1) {
            return "Sorry, only for Admins";
        }

        $repo_plugins = Vsrepo::GetVspackage();
        $plugins = Plugin::where('vs_included', 0)->get();

        foreach($plugins as $plugin) {
            foreach($repo_plugins as $repo_plugin) {

                # For scripts: VSRepo-modulename is equal to DB-Plugin->namespace
                if(isset($repo_plugin['identifier']) && ($plugin->identifier == $repo_plugin['identifier'])) {

                    if(isset($repo_plugin['namespace'])  && ($plugin->namespace == $repo_plugin['namespace']) || # is a plugin OR
                       isset($repo_plugin['modulename']) && ($plugin->namespace == $repo_plugin['modulename']))  # is a script (has no namespace attribute in vspackage)
                    {
                            if(isset($repo_plugin['releases'][0]['version'])){
                                $plugin->version = $repo_plugin['releases'][0]['version'];
                            }
                            if(isset($repo_plugin['releases'][0]['published'])){
                                $plugin->version_published = $repo_plugin['releases'][0]['published'];
                            }
                            $plugin->vsrepo = true;
                            $plugin->releases = json_encode($repo_plugin['releases']);

                            if(isset($repo_plugin['dependencies'])) {
                                $plugin->dependencies = rtrim(implode(',', $repo_plugin['dependencies']), ',');
                            }
                    }

                    # ~100 queries, but who cares ;-)
                    DB::table('plugins')->where('id', $plugin->id)
                            ->update([
                                'version' => $plugin->version,
                                'version_published' => $plugin->version_published,
                                'vsrepo' => $plugin->vsrepo,
                                'dependencies' => $plugin->dependencies,
                                'releases' => $plugin->releases,
                            ]);
                }

            }
        }
        return "<h1>synced</h1>";

    }

}
