<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option_languages extends Model
{
    protected $table = 'option_languages';

    public $timestamps = false;
    
    protected $fillable = ['option_id', 'language', 'value'];

    public function option()
    {
        return $this->belongsTo('App\Models\Option');
    }

}
