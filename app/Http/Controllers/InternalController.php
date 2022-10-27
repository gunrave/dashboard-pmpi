<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Answer;
use Yajra\Datatables\Datatables;

class InternalController extends Controller
{
    public function index()
	{
		
		$total = Layanan::all();
		return view('internals.index', compact('total'));
	}
	
	public function getUnit(){
		$layanan = '187854';
		$table = 'lime_survey_'.$layanan;
		$unit = '4045';
		$demografi = '301';
		$kolom = $layanan.'X'.$demografi.'X'.$unit;
		
		$model = new Answer($kolom);
		
		$data = $model->withCount('sekre')
					  ->where('qid',$unit)
				      ->get(['id', 'code', 'answer', 'qid']);
		return DataTables::of($data)
		->addIndexColumn()
		->make(true);
	}
}
