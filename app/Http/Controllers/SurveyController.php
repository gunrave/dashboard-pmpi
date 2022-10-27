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
	 public function __construct()
	 {
		 $this->startdate = '2022-07-25 00:00:00';
	 }
	 
	 
    public function index()
    {
		$gender_intern = '3635';
		$old_intern = '3634';
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

		//Cek gender eksternal
		$eksterns = $this->QueEkstern($survey_ekstern, $disco_ekstern, $gender_ekstern);
		$labels_ekstern = $eksterns->keys();
		$data_ekstern = $eksterns->values();
		
		$ekstern = Pmpi::where('startdate', '>=',$this->startdate);
		$intern = Intern::where('startdate', '>=',$this->startdate);
	
		return view('surveys.index',compact('labels_intern', 'data_intern', 'pegawai', 'labels_ekstern', 'data_ekstern', 'responden', 'ekstern','intern'));
		
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
	
	public function dash()
	{
		$ekstern = Pmpi::where('startdate', '>=',$this->startdate);
		$intern = Intern::where('startdate', '>=',$this->startdate);
		return view('surveys.page1', compact(['ekstern','intern']));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function getUnit()
	 {
		$column = '3772';
		$survey = '385734';
		$grup = '287';
		$columnname = $survey.'X'.$grup.'X'.$column;
		$table = 'lime_survey_'.$survey;
		
		$model = new Answer($columnname);
		
		$data = $model->withCount(['instansi' => function(Builder $query){
							$query->where('startdate', '>=',$this->startdate) ;
						}])
					  ->where('qid',$column)
				      ->get(['id', 'code', 'answer', 'qid']);
		/*
		$data = Answer::withCount(['instansi' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])		->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
				*/
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
		
		$survey = '385734';
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
			$query->where('startdate', '>=',$this->startdate);
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
		$survey = '237932';
		$grup = '280';
		$column = '3598';
		$columnname = $survey.'X'.$grup.'X'.$column;
		$table = 'lime_survey_'.$survey;
		
		$model = new Answer($columnname);
		
		$data = $model->withCount(['internal' => function(Builder $query){
			$query->where('startdate', '>=',$this->startdate);
		}])		->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
		
		/*
		$data = Answer::withCount(['internal' => function(Builder $query){
			$query->whereNotNull('submitdate');
		}])		->where('qid',$column)
				->get(['id', 'code', 'answer', 'qid']);
		*/	
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
	 public function getDetailsUnitInternal(Request $request)
	{
		$id = $request->input('id');
		$respon = $id;
		
		$survey = '237932';
		$table = 'lime_survey_'.$survey;

		$questions = Question::where(function ($query) use ($survey, $respon) {
					$query->where('sid', $survey);
					$query->where('relevance','like','%"'.$respon.'"%');
					})->select(DB::raw("CONCAT(sid, 'X', gid, 'X', qid) AS columnname, qid"))
					->first();

		$column = $questions->columnname;
		$qid = $questions->qid;	
		
		$model = new Answer($column);
		$detail = $model->withCount(['dalem' => function(Builder $query){
			$query->where('startdate', '>=',$this->startdate);
		}])
					->where(function ($q) use ($qid){
						$q->where('qid', $qid);
					})->get(['code', 'answer']);
		return DataTables::of($detail)
			->make(true);
	}
    public function download()
	{
		$filePath = public_path("file/Buku Manual PMPI 2022.pdf");
		$headers = ['Content-Type: application/pdf'];
		//$filename = time().'.pdf';
		
		return response()->download($filePath, "Buku Manual PMPI 2022.pdf", $headers);
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
