<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	public $timestamps = false;

    protected $table = 'languages';

    protected $fillable = ['title', 'shot', 'locale', 'position', 'turnon'];
}
