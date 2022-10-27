<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pmpi;
use App\Models\Intern;
use App\Models\Answer;
use DB;

class DemografiController extends Controller
{
	public function __construct()
	 {
		 $this->startdate = '2022-07-25 00:00:00';
	 }
    public function QueIntern($survey, $group, $question){
		$column = $survey.'X'.$group.'X'.$question;//inisiasi kolom yang akan di pakai
		return Intern::select(DB::raw("COUNT(".$column.") AS data"), DB::raw($column." AS label"))//inisiasi kolom apa yang akan dijadikan data dan label pada Tabel PMPI Internal
				->where('startdate', '>=',$this->startdate)//data yang digunakan adalah data setelah tanggal 25 Juli 2022
				->groupBy(DB::raw($column))
				->pluck('data', 'label');
	}
	public function QueEkstern($survey, $group, $question){
		$column = $survey.'X'.$group.'X'.$question;
		return Pmpi::select(DB::raw("COUNT(".$column.") AS data"), DB::raw($column." AS label"))
				->where('startdate', '>=',$this->startdate)
				->groupBy(DB::raw($column))
				->pluck('data', 'label');
	}
	
	public function QueSpesific($table, $survey, $group, $jawaban){
		$column = $survey.'X'.$group.'X'.$jawaban;//inisiasi kolom yang akan di pakai
		$model = new Answer($column);//inisiasi table answer akan dijoin pada kolom yang mana
		return $model->join($table.' AS s', 'lime_answers.code' , '=',  's.'.$column)//join dengan table internal dan kolom yang akan dijoin
					->where('lime_answers.qid', $jawaban)
					->where('startdate', '>=',$this->startdate)
					->select(DB::raw("COUNT(".$column.") AS data"), "lime_answers.answer AS label")
					->groupBy(DB::raw('lime_answers.answer'))
					->pluck('data', 'label');
	}
	
	public function index()
    {
		$gender_intern = '3635';
		$old_intern = '3634';
		$pendidikan_intern = '3636';
		$disco_intern = '280';
		$survey_intern = '237932';
		$table_intern = 'lime_survey_'.$survey_intern;
		$column_intern = $survey_intern.'X'.$disco_intern.'X'.$gender_intern;
		$model_intern = 'Intern';
		
		$gender_ekstern = '3816';
		$disco_ekstern = '287';
		$survey_ekstern = '385734';
		$table_ekstern = 'lime_survey_'.$survey_ekstern;
		$column_ekstern = $survey_ekstern.'X'.$disco_ekstern.'X'.$gender_ekstern;
		$model_ekstern = 'Pmpi';
		
		$pegawai = Intern::where('startdate', '>=',$this->startdate);
		$responden = Pmpi::where('startdate', '>=',$this->startdate);
		
		//Cek gender internal
		$interns = $this->QueIntern($survey_intern, $disco_intern, $gender_intern);
		$labels_intern = $interns->keys();
		$data_intern = $interns->values();
		
		//Cek usia internal
		$usia_interns = $this->QueSpesific($table_intern, $survey_intern, $disco_intern, '3634');
		$labels_usia_intern = $usia_interns->keys();
		$data_usia_intern = $usia_interns->values();
		
		//Cek golongan internal
		$edu_interns = $this->QueSpesific($table_intern, $survey_intern, $disco_intern, '3636');
		$labels_edu_intern = $edu_interns->keys();
		$data_edu_intern = $edu_interns->values();
		
		//Cek jabatan internal
		$jab_interns = $this->QueSpesific($table_intern, $survey_intern, $disco_intern, '3637');
		$labels_jab_intern = $jab_interns->keys();
		$data_jab_intern = $jab_interns->values();
		
		//Cek golongan internal
		$gol_interns = $this->QueSpesific($table_intern, $survey_intern, $disco_intern, '3639');
		$labels_gol_intern = $gol_interns->keys();
		$data_gol_intern = $gol_interns->values();
		
		//Cek masa kerja nternal
		$masker_interns = $this->QueSpesific($table_intern, $survey_intern, $disco_intern, '3638');
		$labels_masker_intern = $masker_interns->keys();
		$data_masker_intern = $masker_interns->values();
		
		//Cek gender eksternal
		$eksterns = $this->QueEkstern($survey_ekstern, $disco_ekstern, $gender_ekstern);
		$labels_ekstern = $eksterns->keys();
		$data_ekstern = $eksterns->values();
		
		//Cek frekuenasi eksternal
		$frek_externs = $this->QueSpesific($table_ekstern, $survey_ekstern, $disco_ekstern, '3814');
		$labels_frek_extern = $frek_externs->keys();
		$data_frek_extern = $frek_externs->values();
		
		//Cek pendidikan eksternal
		$edu_externs = $this->QueSpesific($table_ekstern, $survey_ekstern, $disco_ekstern, '3818');
		$labels_edu_extern = $edu_externs->keys();
		$data_edu_extern = $edu_externs->values();
		
		//Cek pekerjaan eksternal
		$work_externs = $this->QueSpesific($table_ekstern, $survey_ekstern, $disco_ekstern, '3820');
		$labels_work_extern = $work_externs->keys();
		$data_work_extern = $work_externs->values();
		
		//Cek kepentingan eksternal
		$penting_externs = $this->QueSpesific($table_ekstern, $survey_ekstern, $disco_ekstern, '3821');
		$labels_penting_extern = $penting_externs->keys();
		$data_penting_extern = $penting_externs->values();
		
		$ekstern = Pmpi::where('startdate', '>=',$this->startdate);
		$intern = Intern::where('startdate', '>=',$this->startdate);
	
		return view('surveys.demografi',compact('labels_intern', 'data_intern', 'pegawai', 'labels_ekstern', 'data_ekstern', 'responden', 'labels_usia_intern', 'data_usia_intern','labels_edu_intern','data_edu_intern','labels_jab_intern','data_jab_intern','labels_gol_intern','data_gol_intern','labels_masker_intern','data_masker_intern','labels_frek_extern','data_frek_extern','labels_edu_extern','data_edu_extern','labels_work_extern','data_work_extern','labels_penting_extern','data_penting_extern'));
	}
}
