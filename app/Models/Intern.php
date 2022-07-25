<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\FilteredData;

class Intern extends Model
{
    use HasFactory;
	protected $connection = 'mysql2';
	protected $table = 'lime_survey_237932';
	protected $field;
	
	protected static function booted()
	{
		static::addGlobalScope(new FilteredData);
	}
	
}
