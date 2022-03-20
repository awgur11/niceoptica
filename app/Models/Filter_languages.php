<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter_languages extends Model
{
	public $timestamps = false;

    protected $table = 'filters_languages';

    protected $fillable = ['filter_id', 'language', 'title'];
}