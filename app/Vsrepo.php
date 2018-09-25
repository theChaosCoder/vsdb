<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use ZipArchive;

class Vsrepo extends Model
{

    /**
     * Download vspackage.zip, unpack it and return it as an array.
     * Checks if vspackage.zip changed since the last call,
     * otherwise return "old" vspackage from storage.
     */
    public function scopeGetVspackage()
	{
        #TODO return status codes
        $download_url = 'http://www.vapoursynth.com/vsrepo/vspackages.zip';

        $vs_headers = Cache::remember('vs_headers', 120, function() use ($download_url) { # cache 120min
            return get_headers($download_url, 1);
        });
        #$vs_headers = get_headers($download_url, 1);

        if(isset($vs_headers['Last-Modified']) && Storage::exists('vsrepo/vsrepo-lastmod')) {
            if((Storage::get('vsrepo/vsrepo-lastmod') == $vs_headers['Last-Modified']) && Storage::exists('vsrepo/vspackages.json')) { # if local == remote
                $json = json_decode(Storage::get('vsrepo/vspackages.json'), true);
                if($json['file-format'] != "2") {
                    return ['name' => 'format has changed'];
                }
                return json_decode(Storage::get('vsrepo/vspackages.json'), true)['packages'];
            }
        }

        # vspackage is newer or vspackages.json doesn't exist
        if(isset($vs_headers['Last-Modified'])) {
            $vspackage_file = file_get_contents($download_url);

            Storage::put('vsrepo/vspackages.zip', $vspackage_file);
            Storage::put('vsrepo/vsrepo-lastmod', $vs_headers['Last-Modified']);

            $zip = new ZipArchive;
            if ($zip->open(Storage::path('vsrepo/vspackages.zip')) === TRUE) {
                $zip->extractTo(Storage::path('vsrepo/'));
                $zip->close();
            } else {
                return ' error zip';
            }

            return json_decode(Storage::get('vsrepo/vspackages.json'), true)['packages'];
        }
        return [];
	}

}
