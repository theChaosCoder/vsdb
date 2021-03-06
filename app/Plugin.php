<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Plugin extends Model
{
    use SoftDeletes;
    protected $appends = array('is_collection');


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

    /**
     * Check if a plugin belongs to a Collection category
     * Currently hardcoded id!
     */
    public function getIsCollectionAttribute(): bool
    {
        if($this->categories_id == 4) {
            return true;
        }
        return false;
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

	/*public function getRouteKeyName()
	{
		return 'namespace';
	}*/
}
