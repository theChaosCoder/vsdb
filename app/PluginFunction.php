<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

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


    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
