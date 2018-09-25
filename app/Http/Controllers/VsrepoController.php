<?php

namespace App\Http\Controllers;
use App\Plugin;
use App\Category;
use Illuminate\Http\Request;

class VsrepoController extends Controller
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
    public function list()
    {
        $plugins = Plugin::orderBy('name', 'asc')->where('vsrepo', 0)->where('vs_included', 0)->with('categories')->get();
		return view('vsrepo.list', compact('plugins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate($id)
    {
        $plugin = Plugin::where('id', $id)->first();
        #return $plugin;

        $vspackage['name'] = $plugin->name;
        $vspackage['type'] = $plugin->type;
        $vspackage['description'] = $plugin->description;
        if(!empty($plugin->url_website)) {
            $vspackage['website'] = $plugin->url_website;
        }
        if(!empty($plugin->url_github)) {
            $vspackage['github'] = $plugin->url_github;
        }
        if(!empty($plugin->url_doom9)) {
            $vspackage['doom9'] = $plugin->url_doom9;
        }
        $vspackage['category'] = $plugin->categories['name'];

        $vs_version = "";
        $vspackage['identifier'] = $plugin->identifier;
        if($plugin->type == "VSPlugin") {
            $vspackage['namespace'] = $plugin->namespace;
            $vs_version = [
                        'win32' => [
                            'url' => '',
                            'files' => [
                                'changeme.dll' => [
                                    'changeme.dll',
                                    "HASH"
                                ]
                            ]
                        ],
                        'win64' => [
                            'url' => '',
                            'files' => [
                                'changeme.dll' => [
                                    'changeme.dll',
                                    "SHA256"
                                ]
                            ]
                        ],
                    ];
        }
        if($plugin->type == "PyScript") {
            $vspackage['modulename'] = $plugin->namespace;
            $vspackage['dependencies'] = [];
            $vs_version = [
                        'script' => [
                            'url' => '',
                            'files' => [
                                'changeme.py' => [
                                    'changeme.py',
                                    "SHA256"
                                ]
                            ]
                        ],
                    ];
        }

        $vspackage['releases'] = [
                        'version' => "",
                        'published' => "",
                        $vs_version
                    ];

        #TODO how to remove key-index in final json output
        #$vspackage['releases'] = array_values($vspackage['releases']);
        #$vspackage =json_encode($vspackage, true);
        return response()->json($vspackage, 200, [], JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
