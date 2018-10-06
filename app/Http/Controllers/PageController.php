<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plugin;
use App\PluginFunction;
use App\Category;
use Illuminate\Support\Facades\Storage;
use App\Vsrepo;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['dashboard', 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function plugins()
    {
        $plugins = Plugin::with('functions.categories', 'categories')->get();
        #$plugins_tmp =  clone $plugins;

        #inject "Plugins" from Collection category
        foreach($plugins as $plugin) {
            #return $plugin;
            if($plugin->is_collection) {

                foreach($plugin->functions as $func) {
                    #$p = clone $plugin;

                    # TODO refactor ugly code, check why new Plugin() triggers extra db queries.
                    $arr = array();
                    $arr['functions'] = array();
                    $arr['categories'] = array();
                    $p = json_decode(json_encode($arr));

                    $p->name = $func->name;
                    $p->categories_id = $func->categories_id;
                    $p->categories['name'] = $func->categories['name'];
                    $p->description = $func['description'];
                    $p->type = $plugin['type'];
                    $p->identifier = $plugin['identifier'];
                    $p->namespace = $plugin['namespace'];
                    $p->gpusupport = $plugin['gpusupport'];
                    $p->vs_included = $plugin['vs_included'];
                    $p->version_published = $plugin->version_published;
                    $p->shortalias = $plugin['shortalias'];
                    $p->url_github = $plugin['url_github'];
                    $p->url_doom9 = $plugin['url_doom9'];
                    $p->url_website = $plugin['url_website'];
                    $p->url_avswiki = $plugin['url_avswiki'];

                    if($p->name == $func->name) { # the new *fake* plugin needs only its own plugin-function
                        $p->functions[] = $func;
                    }
                    $p->releases = $plugin['releases'];
                    $p->dependencies = $plugin['dependencies'];
                    #print_r($p); die;
                    $plugins[] = $p;

                } #return $plugins_tmp; die;
            }

        }
        #echo "<pre>";print_r($plugins); die;
        #return $plugins;
		return view('plugins.plugins', compact('plugins'));
    }



    /**
     * Display the specified resource.
     * $id_slug can be id or namespace. Namespace can return multiple records
     *
     * @param  mixed  $id_slug
     * @return \Illuminate\Http\Response
     */
    public function show($id_slug)
    {
        $plugins = [];

        if(intval($id_slug)) {
            if(intval($id_slug) > 0) {
                $plugins = Plugin::with('functions.categories')->where('id', $id_slug)->get();
            }
        } else {
            $plugins = Plugin::with('functions.categories')->where('namespace', $id_slug)->get();
        }

        return view('plugins.show', compact('plugins', 'categories'));

    }


    /**
     *
     */
    public function vsrepogui()
    {
        $plugins = Vsrepo::GetVspackage();
        return view('plugins.vsrepogui', compact('plugins'));

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard.index');
    }



    /**
     * calc plugin statistics
     */
    public function stats()
    {
        #$repo_plugins = Vsrepo::GetVspackage();
        $categories = Category::all();
        $plugins = Plugin::with('categories')->get();
        $pfunctions = PluginFunction::all();

        $collection_ids = $plugins->where('is_collection')->pluck('id'); #->where('vs_included', 0)
        $plugin_col_pfunctions = $pfunctions->whereIn('plugin_id', $collection_ids);

        $count = [];
        $count['plugins']               = $plugins->count();
        $count['type_plugin']           = $plugins->where('type', 'VSPlugin')->count();
        $count['type_script']           = $plugins->where('type', 'PyScript')->count();
        $count['pfunctions']            = $pfunctions->count();
        $count['collections']           = $collection_ids->count();
        $count['vsrepo']                = $plugins->where('vsrepo', 1)->count();
        $count['plugins_and_col_functions'] = $plugin_col_pfunctions->count() + $count['plugins'] - $count['collections'];
        #return $count;

        # categories of pluginfunctions collections
        $pfunc_group = $plugin_col_pfunctions->groupBy('categories_id');
        $plugins_group = $plugins->groupBy('categories_id');

        $c = [];
        foreach($pfunc_group as $key => $item)
        {
            $c[$categories->where('id', $key)->first()->name] = ['count' => $item->count()];
        }

        foreach($plugins_group as $key => $item)
        {
            $cat = $categories->where('id', $key)->first()->name;
            if(!isset($c[$cat])) {
                $c[$cat] = ['count' => $item->count()];
            } else {
                $c[$cat] = ['count' => ($c[$cat]['count'] + $item->count())];
            }
        }

        $c = collect($c); #easier to sort
        $c = $c->sortByDesc('count');
        $count['categories']['name'] = json_encode(array_keys($c->toArray()));
        $count['categories']['count'] = $c->pluck('count');
        #return $count;

        $dupes = $plugins->groupBy('namespace')->filter(function ($value, $key) {
            return $value->count() > 1;
        });
        #return $dupes;

        return view('plugins.stats')->with(compact('plugins', 'count', 'dupes'));
    }


}
