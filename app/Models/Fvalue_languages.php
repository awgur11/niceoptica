<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fvalue_languages extends Model
{
	public $timestamps = false;

    protected $table = 'fvalues_languages';

    protected $fillable = ['fvalue_id', 'language', 'title'];
}