<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'deliveries';

    protected $fillable = ['option', 'city', 'warehouse', 'street', 'house', 'flat', 'user_id', 'city_ref', 'warehouse_ref', 'street_ref', 'main'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
