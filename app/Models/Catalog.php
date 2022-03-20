<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $table = 'catalogs';

    protected $fillable = ['alt_title', 'category_id', 'parent_id', 'preview_name', 'preview_path',  'tag_title', 'description', 'public', 'home_page', 'user_id'];

    protected $appends = ['fhd_preview', 'one_preview', 'two_preview', 'tree_preview', 'four_preview', 'five_preview', 'six_preview', 'mini_preview'];

    protected $no_photo = '/storage/images/no-photo.jpg';

    public function languages()
    {
        return $this->hasMany('App\Models\Catalog_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Catalog_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
                'menu' => '',
                'content' => '',
                'description' => '',
                'tag_title' => ''
            ]);
    }

    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter')->orderBy('position');
    }

    public function fvalues($filter_id = null)
    {
        if($filter_id != null)
            return $this->belongsToMany('App\Models\Fvalue')->where('filter_id', $filter_id)->orderBy('position');
        else
            return $this->belongsToMany('App\Models\Fvalue')->orderBy('position');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    } 

    public function parent()
    {
        return $this->belongsTo('App\Models\Catalog', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Catalog', 'parent_id')->orderBy('position')->where('public', 1);
    }

    public function getFhdPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'fhd-'.$this->preview_name);
    }

    public function getOnePreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'one-'.$this->preview_name);
    }

    public function getTwoPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'two-'.$this->preview_name);
    }

    public function getTreePreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'tree-'.$this->preview_name);
    }

    public function getFourPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'four-'.$this->preview_name);
    }

    public function getFivePreviewAttribute()
    {
        if($this->preview_name == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'five-'.$this->preview_name);
    }

    public function getSixPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'six-'.$this->preview_name);
    }
 
    public function getMiniPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.'mini-'.$this->preview_name);
    }

    public function first_products()
    {
        return $this->hasMany('App\Models\Product', 'catalog_id')->where('public', 1);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
