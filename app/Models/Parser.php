<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    protected $table = 'parser';

    protected $fillable = ['url', 'catalog_id', 'status', 'errors', 'pause'];

    public $timestamps = false;

    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog');
    }
}