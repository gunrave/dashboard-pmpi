<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pmpi extends Model
{
    use HasFactory;
	protected $connection = 'mysql2';
	protected $table = 'lime_survey_789933';
	protected $field;
	
	public function Answer()
	{
		return $this->belongsTo(Answer::class);
	}
}
