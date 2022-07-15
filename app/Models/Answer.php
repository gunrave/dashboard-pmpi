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
		//$column = '3772';
		return $this->hasMany(Pmpi::class, $this->field, 'code');
	}
	
	public function internal()
	{
		//$column = '3598';
		return $this->hasMany(Intern::class, $this->field, 'code');
	}
	
	public function question()
	{
		return $this->hasMany(Question::class);
	}

	public function unit()
	{
		
		return $this->hasMany(Pmpi::class, $this->field, 'code');
	}
	
	public function dalem()
	{
		
		return $this->hasMany(Intern::class, $this->field, 'code');
	}

}
