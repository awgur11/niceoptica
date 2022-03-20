<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';

    public $timestamps = false;
    
    protected $fillable = ['product_id', 'page_id', 'colour_id', 'preview_path', 'preview_name', 'type', 'extension',  'position', 'user_id'];
 
    protected $appends = ['fhd_preview', 'one_preview', 'two_preview', 'tree_preview', 'four_preview', 'five_preview', 'six_preview', 'mini_preview'];

    protected $no_photo = '/storage/images/no-photo.jpg';

    public function products()
    {
      return $this->belongsTo('App\Models\Picture');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\Picture_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Picture_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
            ]);
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
