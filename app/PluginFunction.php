<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginFunction extends Model
{
    use SoftDeletes;
	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function plugins(): BelongsTo
	{
		return $this->belongsTo(Plugin::class, 'plugin_id');
	}

	public function categories(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
}
