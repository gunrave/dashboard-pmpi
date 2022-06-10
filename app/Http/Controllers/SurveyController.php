<?php

namespace App\Http\Controllers;

use App\Models\survey;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Pmpi;
use App\Http\Requests\StoresurveyRequest;
use App\Http\Requests\UpdatesurveyRequest;
use DB;
Use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index()
    {
		$column = '2788';
        $surveys = Answer::paginate();
		$count_surveys = Answer::withCount('instansi')
				->where('qid',$column)->get();
		
		return view('surveys.index',[
			'surveys' => $surveys,
			'count' => $count_surveys,
			$surveys->toArray()	
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function getUnit()
	 {
		$column = '2787';
		$data = Answer::withCount('instansi')
				->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
				
		return DataTables::of($data)
			->addColumn('details_url', function($data) {
				return url('eloquent/details-data/'. $data->qid);
				//return '<a href="#edit-'.$data->qid.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
			})
			->addIndexColumn()
			
			->addColumn('Actions', function ($data){
				$detail = '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-detail"  data-id="'.$data->qid.'" ><i class="fa fa-edit"></i> DETAIL</button>';
				return $detail;
			})
			->rawColumns(['Actions','checked'])
			->make(true);
	 }
	 
	public function getDetailsUnit(Request $request)
	{
		$id = $request->input('id');
		$respon = $id;
		
		$survey = '789933';
		$table = 'lime_survey_'.$survey;
		//print_r($respon.' '.$survey);
		$questions = Question::where(function ($query) use ($survey, $respon) {
					$query->where('sid', $survey);
					$query->where('relevance','like','%"'.$respon.'"%');
					})->select(DB::raw("CONCAT(sid, 'X', gid, 'X', qid) AS columnname, qid"))
					->first();
		
		//print_r($questions);
		$column = $questions->columnname;
		$qid = $questions->qid;
		//$column = $table.'.'.$column;
		/*
		$detail = Answer::join('lime_survey_'.$survey, 'lime_survey_'.$survey.'.columnname', 'lime_answers.code')
					->get(['lime_survey_'.$survey.'.columname', '']);
					
		$detail = Pmpi::join('lime_answers',function($join1) use ($column, $respon){
			$join1->on($column, '=', 'lime_answers.code');
			$join1->where($column, $respon);
		})->toSql();
		/*
		$detail1 = Answer::withCount(['unit' => function(Builder $query) use ($column, $survey){
			$query->on('lime_survey_'.$survey.'.'.$column, '=', 'lime_answers.code');
		},])->toSql();
		*/		
		
		$model = new Answer($column);
		$detail = $model->withCount('unit')
					->where(function ($q) use ($qid){
						$q->where('qid', $qid);
					})->get(['code', 'answer']);
		/*
		$detail = Answer::withCount('unit')
					->where('qid', $column)
					->get(['code', 'answer']);
					
		/*$detail = Question::withCount('survey')
					->where('qid', '2788')
					->get(['id', 'code', 'answer']);
		*/
		//print_r($detail);
		return DataTables::of($detail)
			->make(true);
	}	
	 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresurveyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesurveyRequest  $request
     * @param  \App\Models\survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesurveyRequest $request, survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(survey $survey)
    {
        //
    }
}
