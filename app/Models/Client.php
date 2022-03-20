<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{    
    protected $table = 'clients';
   
    protected $fillable = ['first_name',  'middle_name', 'last_name', 'email', 'phone', 'address', 'subscribed'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function setAddressAttribute($value)
    { 
        $this->attributes['address'] = json_encode($value);
    }

    public function getAddressAttribute($value)
    { 
        return json_decode($value, true);
    }

}
