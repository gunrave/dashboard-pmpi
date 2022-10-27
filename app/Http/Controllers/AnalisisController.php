<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use DB;
use Yajra\Datatables\Datatables;

class AnalisisController extends Controller
{
	public function __construct()
	 {
		 $this->startdate = '2022-07-25 00:00:00';
	 }
	 
    public function index()
	{
		return view('surveys.analisis.internal');
	}
	
	public function find(Request $request)
	{
		$column = '3598';
		$term = trim($request->q);
		
		$tags = [];
		
		if($request->filled('q')){
			$tags = Answer::select("answer", "code")
				->where('qid', $column)
				->where('answer', 'LIKE', '%'.$term.'%')
				->get();
		}else{
			$tags = Answer::select("answer", "code")
				->where('qid', $column)
				->get();
		}

		return response()->json($tags);
	}
	
	public function findUPT(Request $request)
	{
		$respon = $request->input('id');
		$survey = '237932';
		$table = 'lime_survey_'.$survey;
		
		$questions = Question::where(function ($query) use ($survey, $respon) {
						$query->where('sid', $survey);
						$query->where('relevance','like','%"'.$respon.'"%');
					})
					->select(DB::raw("CONCAT(sid, 'X', gid, 'X', qid) AS columnname, qid"))
					->first();
		//dd($questions);
		//$questions = Question::
		$qid = $questions->qid;	
		$column = $questions->columnname;
		
		
		$model = new Answer($column);
		$detail = $model->where(function ($q) use ($qid){
						$q->where('qid', $qid);
					})->get(['code', 'answer']);
		return response()->json($detail);
	}
	
	public function getQuestion(Request $request)
	{
		$id = $request->input('id');
		$respon = $id;
		
		$survey = '237932';
		$table = 'lime_survey_'.$survey;
		
		$detail = Question::where('sid', $survey)
						->where('gid','<>','280')
						->where('parent_qid','0')
						->select(['qid','question']);
		
		return DataTables::of($detail)
			->addIndexColumn()
			->make(true);

/*
		$questions = Question::where(function ($query) use ($survey, $respon) {
					$query->where('sid', $survey);
					$query->where('gid','<>', '280');
					$query->where('parent_id',, '0');
					//$query->where('relevance','like','%"'.$respon.'"%');
					})->select(DB::raw("CONCAT(sid, 'X', gid, 'X', qid) AS columnname, question"))
					->first();

		$column = $questions->columnname;
		$qid = $questions->question;	
		
		$model = new Answer($column);
		$detail = $model->withCount(['unit' => function(Builder $query){
			$query->where('startdate', '>=',$this->startdate);
		}])
					->where(function ($q) use ($qid){
						$q->where('qid', $qid);
					})->get(['code', 'answer']);
		return DataTables::of($detail)
			->make(true);
			*/
	}
}
