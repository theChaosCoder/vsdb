<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plugin;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
	{
		$plugins = Cache::remember('sitemap_plugins', now()->addDays(5), function () {
			return Plugin::orderBy('updated_at', 'desc')->get();
		});

		return response()->view('sitemap', [
		  'plugins' => $plugins,
		])->header('Content-Type', 'text/xml');
	}
}