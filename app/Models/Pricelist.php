<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    protected $table = 'pricelists';

    public $timestamps = false;
    
    protected $fillable = ['product_id', 'param_id_1', 'param_id_2', 'price'];

    public function products()
    {
      return $this->belongsTo('App\Models\Products');
    }

    public function getPriceAttribute($price)
    {
      return $price/100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    public function fvalue_1()
    {
      return $this->belongsTo('App\Models\Fvalue', 'param_id_1');
    }

    public function fvalue_2()
    {
      return $this->belongsTo('App\Models\Fvalue', 'param_id_2');
    }
 
}
