<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
	protected $connection = 'mysql2';
	protected $table = 'lime_answers';
	protected $field;
	public function __construct($field = 'id')
	{
		$this->field = $field;
	}
	
	
	public function instansi()
	{
		$column = '2787';
		return $this->hasMany(Pmpi::class, '789933X238X'.$column, 'code');
	}
	
	public function internal()
	{
		$column = '2617';
		return $this->hasMany(Intern::class, '458625X231X'.$column, 'code');
	}
	
	public function question()
	{
		return $this->hasMany(Question::class);
	}

	public function unit()
	{
		
		return $this->hasMany(Pmpi::class, $this->field, 'code');
	}

}
