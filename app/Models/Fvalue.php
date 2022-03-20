<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fvalue extends Model
{
	public $timestamps = false;

    protected $table = 'fvalues';

    protected $fillable = ['preview_path', 'preview_name', 'filter_id', 'alt_title', 'position'];

    protected $no_photo = '/storage/images/no-photo.jpg';

    protected $appends = ['origin_preview'];

    public function languages()
    {
        return $this->hasMany('App\Models\Fvalue_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Fvalue_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
            ]);
    }

    public function filter()
    {
        return $this->belongsTo('App\Models\Filter');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->orderBy('position');
    }

    public function catalogs()
    {
        return $this->belongsToMany('App\Models\Catalog');
    }

    public function getOriginPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.$this->preview_name);
    }
}
