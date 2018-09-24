<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plugin extends Model
{
	#protected $fillable = ['namespace', 'shortalias', 'identifier', 'name', 'category', 'version', 'version_published', 'type', 'gpusupport',
	#					   'url_github', 'url_doom9', 'url_avswiki', 'url_website', 'vsrepo', 'releases', 'description', 'deprecated', 'dependencies'];
	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function functions(): HasMany
	{
		return $this->hasMany(PluginFunction::class)->select('id', 'plugin_id', 'name', 'description', 'categories_id', 'bitdepth', 'colorspace', 'gpusupport', 'deprecated', 'created_at', 'updated_at', 'deleted_at');
	}

	public function categories(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}



	/*public function getRouteKeyName()
	{
		return 'namespace';
	}*/
}
