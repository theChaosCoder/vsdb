<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public function plugins(): HasMany
	{
		return $this->hasMany(Plugin::class);
	}

	public function functions(): HasMany
	{
		return $this->hasMany(PluginFunctions::class);#, 'category_id');
	}
}
