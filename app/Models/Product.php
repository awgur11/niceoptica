<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $no_photo = '/storage/images/no-photo.jpg';

    protected $table = 'products';

    protected $fillable = ['code', 'alt_title', 'articule', 'catalog_id', 'price', 'discount', 'nacenka', 'final_price', 'params', 'content', 'available', 'promo', 'novelty', 'public', 'position', 'parent_id', 'different_eyes'];

    public function languages()
    {
        return $this->hasMany('App\Models\Product_languages');      
    }

    public function language($locale = null)
    {
        $locale = $locale ?? \App::getLocale();

        return $this->hasOne('App\Models\Product_languages')->where('language', $locale)->withDefault([
                'title' => '',
                'content' => '',
                'shot_content'=> '',
                'params' => '',
                'specification' => '',
                'description' => '',
                'tag_title' => ''
            ]);
    }

    public function pictures()
    { 
      return $this->hasMany('App\Models\Picture')->orderBy('position')->whereIn('extension', ['jpg', 'gif', 'png', 'webp']);
    }

    public function files()
    { 
        return $this->hasMany('App\Models\Picture')->orderBy('position')->whereIn('extension', ['pdf']);
    }

    public function picture()
    { 
        return $this->hasOne('App\Models\Picture')
            ->whereIn('extension', ['png', 'jpg', 'webp', 'jpeg'])
            ->orderBy('position')
            ->withDefault([
                'mini_preview' => $this->no_photo,
        ]);
    } 

    public function video()
    {
        return $this->hasOne('App\Models\Picture')->whereIn('extension', ['mp4'])->orderBy('position');
    }

    public function videos()
    {
        return $this->hasMany('App\Models\Picture')->whereIn('extension', ['mp4'])->orderBy('position');
    }

    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog');
    }

    public function fvalues()
    {
        return $this->belongsToMany('App\Models\Fvalue')->withPivot('price')->orderBy('position');
    }

    public function colours()
    {
        return $this->belongsToMany('App\Models\Colour');
    }

    public function comments()
    {
      return $this->hasMany('App\Models\Comment')->where('status', 1);
    }

    public function getPriceAttribute($price)
    {
      return $price/100;
    }
 
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    public function getFinalPriceAttribute($price)
    {
      return $price/100;
    }

    public function setFinalPriceAttribute($value)
    {
        $this->attributes['final_price'] = $value*100;
    }

    public function pricelist()
    {
        return $this->hasMany('App\Models\Pricelist');
    }

}
