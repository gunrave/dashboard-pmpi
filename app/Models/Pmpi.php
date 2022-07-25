<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\FilteredData;

class Pmpi extends Model
{
    use HasFactory;
	protected $connection = 'mysql2';
	protected $table = 'lime_survey_385734';
	protected $field;
	
	public function Answer()
	{
		return $this->belongsTo(Answer::class);
	}
	
	protected static function booted()
	{
		static::addGlobalScope(new FilteredData);
	}
}
