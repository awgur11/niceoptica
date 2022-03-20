<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
	public $timestamps = false;

    protected $table = 'filters';

    protected $fillable = ['alt_title', 'active', 'for_cart', 'position', 'merchant'];

    public function languages()
    {
        return $this->hasMany('App\Models\Filter_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Filter_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
            ]);
    }
 
    public function fvalues()
    {
    	return $this->hasMany('App\Models\Fvalue')->orderBy('position');
    }

    public function catalogs()
    {
        return $this->belongsToMany('App\Models\Catalog')->orderBy('position');
    } 


}
