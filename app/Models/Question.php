<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
	protected $connection = 'mysql2';
	protected $table = 'lime_questions';
	
	public function survey()
	{
		return $this->hasMany(Survey::class);
	}
	
	public function answer()
	{
		return $this->hasMany(Answer::class,'qid','qid');
	}
}
