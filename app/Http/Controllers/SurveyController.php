<?php

namespace App\Http\Controllers;

use App\Models\survey;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Pmpi;
use App\Models\Intern;
use App\Http\Requests\StoresurveyRequest;
use App\Http\Requests\UpdatesurveyRequest;
use DB;
Use Carbon\Carbon;
use Yajra\Datatables\Datatables;
//use Yajra\Datatables\Html\Builder;
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
		
		$column = '2787';
        $surveys = Answer::paginate();
		$count_surveys = Answer::withCount('instansi')
				->where('qid',$column)->get();
		
		return view('surveys.index',[
			'surveys' => $surveys,
			'count' => $count_surveys,
			$surveys->toArray()	
		]);
		
    }
	
	public function dash()
	{
		$ekstern = Pmpi::whereNotNull('submitdate');
		$intern = Intern::whereNotNull('submitdate');
		return view('surveys.page1', compact(['ekstern','intern']));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function getUnit()
	 {
		$column = '2787';
		$data = Answer::withCount(['instansi' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])		->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
				
		return DataTables::of($data)
			->addColumn('details_url', function($data) {
				return url('eloquent/details-data/'. $data->qid);
			})
			->addIndexColumn()
			
			->addColumn('Actions', function ($data){
				$detail = '<button type="button" class="btn btn-success btn-sm" data-id="'.$data->qid.'" ><i class="fa fa-edit"></i> DETAIL</button>';
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

		$questions = Question::where(function ($query) use ($survey, $respon) {
					$query->where('sid', $survey);
					$query->where('relevance','like','%"'.$respon.'"%');
					})->select(DB::raw("CONCAT(sid, 'X', gid, 'X', qid) AS columnname, qid"))
					->first();

		$column = $questions->columnname;
		$qid = $questions->qid;	
		
		$model = new Answer($column);
		$detail = $model->withCount(['unit' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])
					->where(function ($q) use ($qid){
						$q->where('qid', $qid);
					})->get(['code', 'answer']);
		return DataTables::of($detail)
			->make(true);
	}
	public function getGender()
	 {
		$column = '2787';
		$data = Answer::withCount(['instansi' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])		->where('qid',$column)
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
			 //->skipPaging()
			->rawColumns(['Actions','checked'])
			->make(true);
	 }
	 public function getUnitInternal()
	 {
		$survey = '458625';
		$grup = '231';
		$column = '2617';
		$table = 'lime_survey_'.$survey;
		
		
		$data = Answer::withCount(['internal' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])		->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
				
		return DataTables::of($data)
			->addColumn('details_url', function($data) {
				return url('eloquent/details-data/'. $data->qid);
			})
			->addIndexColumn()
			
			->addColumn('Actions', function ($data){
				$detail = '<button type="button" class="btn btn-success btn-sm" data-id="'.$data->qid.'" ><i class="fa fa-edit"></i> DETAIL</button>';
				return $detail;
			})

			->rawColumns(['Actions','checked'])
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
