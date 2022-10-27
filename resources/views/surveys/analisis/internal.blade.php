@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'Analisis Hasil Survey PMPI')
@section('content_header')	
    <h1 class="m-0 text-dark">Analisis Hasil Survey PMPI</h1>
@stop

@push('css')
	<style>
		td.details-control {
			background: url('https://datatables.yajrabox.com/images/details_open.png') no-repeat center center;
			cursor: pointer;
			width: 18px;
		}
		tr.shown td.details-control {
			background: url('https://datatables.yajrabox.com/images/details_close.png') no-repeat center center;
		}
	</style>
@endpush

@section('content')
	 <div class="row">
		<div class="col-md">
			<div class="card card-primary">
				<div class="card-header">
					<div class="card-title">
						Internal
					</div>
					<div class="card-tools">
					  <!-- This will cause the card to maximize when clicked -->
					  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
					  <!-- This will cause the card to collapse when clicked -->
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					  <!-- This will cause the card to be removed when clicked -->
					  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="col-sm-6">
						<form class="form-horizontal" action="#" method="post">
						  <div class="form-group row">
							<div class="input-group">
								<label class="col-sm-3 col-form-label">Eselon I / Kantor Wilayah</label>
								<div class="col-sm-9">
									<select class="form-control" id="eskw"></select>
								</div>
							</div>
						  </div>
						</form>
						<form class="form-horizontal disabled" action="#" method="post">
						  <div class="form-group row">
							<div class="input-group">
								<label class="col-sm-3 col-form-label">Satuan Kerja</label>
								<div class="col-sm-9">
									<select class="form-control" id="upt"></select>
								</div>
							</div>
						  </div>
						</form>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="small-box bg-info ">
							  <div class="inner">
								<h3>150</h3>
								<p>New Orders</p>
							  </div>
							  <div class="icon">
								<i class="fas fa-shopping-cart"></i>
							  </div>
							  <a href="#" class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							  </a>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="small-box bg-primary">
							  <div class="inner">
								<h3>150</h3>
								<p>New Orders</p>
							  </div>
							  <div class="icon">
								<i class="fas fa-shopping-cart"></i>
							  </div>
							  <a href="#" class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							  </a>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="small-box bg-lightblue">
							  <div class="inner">
								<h3>150</h3>
								<p>New Orders</p>
							  </div>
							  <div class="icon">
								<i class="fas fa-shopping-cart"></i>
							  </div>
							  <a href="#" class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							  </a>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="small-box bg-lime">
							  <div class="inner">
								<h3>150</h3>
								<p>New Orders</p>
							 </div>
							  <div class="icon">
								<i class="fas fa-shopping-cart"></i>
							  </div>
							  <a href="#" class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							  </a>
						</div>
					</div>
					<div>
						<table id="rekap" class="table table-bordered" style="width:100%">
							<thead>
								<tr>
								   <th scope="col" rowspan="2">No.</th>
									<th scope="col" rowspan="2">Pertanyaan</th>
									<th scope="col" colspan="5">Pilihan Jawaban</th>
									<th scope="col" rowspan="2">Total</th>
									<!--<th width="200" class="text-center">Action</th>-->
								</tr>
								<tr>
									<th scope="col">Opsi 1</th>
									<th scope="col">Opsi 2</th>
									<th scope="col">Opsi 3</th>
									<th scope="col">Opsi 4</th>
									<th scope="col">Opsi 5</th>
								</tr>
							</thead>
						</table>
					</div>
					
				</div>
			</div>
		</div>
    </div>
@stop

@push('js')
<script></script>
<script>
$('#eskw').select2({
	placeholder: "Eselon I / Kantor Wilayah",
	//minimumInputLength: 2,
	ajax:{
		url: "{{ route('es1') }}",
		dataType: 'json',
		processResults: function(data){
			data = $.map(data, function(obj){
				obj.id = obj.code;
				obj.text = obj.answer;
				return obj;
			});
			return {
				results:data
			};
		},
		cache:true
	}
});
$('#eskw').on('select2:select', function(e){
	var text = e.params.data.code;
	var address = '{{ route('upt', ":id") }}';
	url = address.replace(':id', text);
	$('#upt').select2({
		placeholder: "Unit Pelaksana Teknis",
		disabled: false,
		ajax:{
			url: url,
			data: { id: text},
			dataType: 'json',
			processResults: function(data){
				data = $.map(data, function(obj){
					obj.id = obj.code;
					obj.text = obj.answer;
					return obj;
				});
				return {
					results:data
				};
			},
			cache:true
		}
	});
	
});

$('#upt').select2({
	placeholder: "Unit Pelaksana Teknis",
	disabled: true,
	
});

var table = $('#rekap').DataTable({
	responsive: true,
	processing: true,
	serverSide: true,
	ajax: '{{ route('question.data') }}',
	columns: [
		{data: 'DT_RowIndex', name : 'DT_RowIndex', orderable:false},
		{data: 'question', name: 'question'},
	],
});
</script>
@endpush