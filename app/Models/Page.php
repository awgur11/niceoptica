<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
      
    protected $fillable = ['type', 'alt_title', 'preview_path', 'preview_name',  'parent_id', 'category_id', 'position', 'public', 'user_id', 'use_in_product', 'menu'];

    protected $appends = ['origin_preview', 'fhd_preview', 'one_preview', 'two_preview', 'tree_preview', 'four_preview', 'five_preview', 'six_preview', 'mini_preview'];

    protected $no_photo = '/storage/images/no-photo.jpg';

    public function languages()
    {
        return $this->hasMany('App\Models\Page_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Page_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
                'menu' => '',
                'content' => '',
                'shot_content' => '',
                'description' => '',
                'tag_title' => ''
            ]); 
    }
 
    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'page_id');
    }

    public function comments()
    {
      return $this->hasMany('App\Models\Comment');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Item', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getOriginPreviewAttribute()
    {
        if($this->preview_path == '')
            return asset($this->no_photo);

        return asset('/storage/images'.$this->preview_path.$this->preview_name);
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
        if($this->preview_path == '')
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

    
}
