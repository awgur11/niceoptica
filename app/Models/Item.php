<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	public $timestamps = false;

    protected $table = 'items';

    protected $no_photo = '/storage/images/no-photo.jpg';

    protected $fillable = ['type', 'preview_name', 'preview_path', 'page_id', 'parent_id', 'text1', 'text2', 'text3', 'nol1', 'nol2', 'nol3', 'public', 'user_id'];

    protected $appends = ['fhd_preview', 'one_preview', 'two_preview', 'tree_preview', 'four_preview', 'five_preview', 'six_preview', 'mini_preview'];

    public function languages()
    {
        return $this->hasMany('App\Models\Item_languages');      
    }

    public function language()
    {
        return $this->hasOne('App\Models\Item_languages')->where('language', \App::getLocale())->withDefault([
                'title' => '',
                'string1' => '',
                'string2' => '',
                'string2' => '',
                'text1' => '',
                'text2' => '',
                'text3' => ''
            ]);
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
    public function children()
    {
        return $this->hasMany('App\Models\Item', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Item', 'parent_id');
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
