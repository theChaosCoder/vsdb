<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PluginFunction;
use App\Plugin;
use App\Category;

class PluginFunctionController extends Controller
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
        $pluginfunctions = PluginFunction::with('plugins')->with('categories')->get();#->orderBy('name', 'asc')->get();
        #return $pluginfunctions;
		return view('pluginfunctions.index', compact('pluginfunctions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $plugins = Plugin::select(['name', 'id'])->get();
        return view('pluginfunctions.create')->with(compact('plugins'))->with(compact('categories'));
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
            #'plugin_id' => 'required|integer',
            'name' =>       'required|max:191',
        ]);

        $pluginfunction = new PluginFunction($request->all());
        $pluginfunction->save();
        return redirect('/pluginfunctions')->with('success', 'Plugin-Function has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "not yet";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PluginFunction  $pluginfunction
     * @return \Illuminate\Http\Response
     */
    public function edit(PluginFunction $pluginfunction)
    {
        #return $pluginfunction;

        $categories = Category::all();
        $plugins = Plugin::select(['name', 'id'])->get();
        return view('pluginfunctions.edit', [
            'pluginfunction' => $pluginfunction,
        ])->with(compact('categories'))->with(compact('plugins'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PluginFunction  $pluginfunction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PluginFunction $pluginfunction)
    {
        $request->validate([
            'plugin_id' => 'required|integer',
            'name' =>       'required|max:191',
        ]);
        $pluginfunction->fill($request->all());
        $pluginfunction->save();
        return redirect('/pluginfunctions')->with('success', 'Plugin has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PluginFunction $pluginfunction, Request $request)
    {
        $pluginfunction->delete();
        if(isset($request['editplugin'])) {
            return redirect('/dashboard/plugins/'.$request['pluginid'].'/edit')->with('success', 'Plugin-Function '.$pluginfunction->name.' has been deleted');
        }
        return redirect('/dashboard/pluginfunctions')->with('success', 'Plugin-Function '.$pluginfunction->name.' has been deleted');
    }
}
