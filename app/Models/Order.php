<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = ['order', 'delivery_id', 'comment', 'status', 'paid', 'user_id', 'sum', 'loyalty_percent'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\Delivery');
    }


    public function setDeliveryAttribute($value)
    { 
        $this->attributes['delivery'] = json_encode($value);
    }

    public function getOrderAttribute($value)
    { 
        return json_decode($value, true);
    }


 
    public function setOrderAttribute($value)
    { 
        $this->attributes['order'] = json_encode($value);
    }

    public function setSumAttribute($value)
    {
        $this->attributes['sum'] = $value*100;
    }

    public function getSumAttribute($sum)
    {
      return $sum/100;
    }
}
