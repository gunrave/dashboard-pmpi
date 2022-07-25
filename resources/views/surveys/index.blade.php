@extends('adminlte::page')
@section('title', 'Data Responden PMPI')
@section('content_header')	
    <h1 class="m-0 text-dark">Data Responden PMPI</h1>
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
        <div class="col-md-6">
			<div class="card"> 
				<div class="card-body">
					<div class="row">
					<h5 class="card-title">Data Responden PMPI Internal <span>| {{ date('d M Y', strtotime(today())) }} |</span> Total : {{ number_format($intern->count()) }} pegawai</h5>
					</div>
					<table id="internal-table" class="table table-striped " style="width:100%">
						<thead>
							<tr>
								
							   <th scope="col">No.</th>
							   <!--<th>Kelompok</th>
							   
								<th>ID</th>-->
								<th scope="col">Unit Kerja/Satker</th>
								<th scope="col">Total Responden</th>
								<th scope="col">Detail</th>
								<!--<th width="200" class="text-center">Action</th>-->
							</tr>
						</thead>
					</table>
				</div>
			</div>
        </div>
		<div class="col-md-6">
			<div class="card"> 
				<div class="card-body">
					<div class="row">
					<h5 class="card-title">Data Responden PMPI Eksternal <span>| {{ date('d M Y', strtotime(today())) }} |</span> Total : {{ number_format($ekstern->count()) }} responden</h5>
					</div>
					<table id="eksternal-table" class="table table-striped " style="width:100%">
						<thead>
							<tr>
								
							   <th scope="col">No.</th>
							   <!--<th>Kelompok</th>
							   
								<th>ID</th>-->
								<th scope="col">Unit Kerja/Satker</th>
								<th scope="col">Total Responden</th>
								<th scope="col">Detail</th>
								<!--<th width="200" class="text-center">Action</th>-->
							</tr>
						</thead>
					</table>
				</div>
			</div>
        </div>
    </div>
	 <div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<canvas id="myChart"></canvas>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<canvas id="myChartEks"></canvas>
				</div>
			</div>
		</div>
    </div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<canvas id="old"></canvas>
				</div>
			</div>
		</div>
	</div>
@stop

@push('js')
<script>
///*
	var labels = {{ Js::from($labels_intern) }};
	var labels_eks = {{ Js::from($labels_ekstern) }};
	var users = {{ Js::from($data_intern) }};
	var users_eks = {{ Js::from($data_ekstern) }};
	
	
	const data = {
		labels : labels,
		datasets : [{
			labels : 'My First dataset',
			backgroundColor: [
				'#ff66cc',
				'#6699ff'
			],
			borderColor: [
				'#CDA776',
				'#989898'
			],
			//borderWidth: [1, 1, 1, 1, 1,1,1],
			data:users,
		}]
	};
	
	const data_eks = {
		labels : labels_eks,
		datasets : [{
			labels : 'My First dataset',
			backgroundColor: [
				'#6ade8a',
				'#ff66cc'
			],
			borderColor: [
				'#CDA776',
				'#989898'
			],
			//borderWidth: [1, 1, 1, 1, 1,1,1],
			data:users_eks,
		}]
	};
	
	const config = {
		type: 'doughnut',
		data: data,
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Jenis Kelamin Responden Internal'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
			}
		},
		
	};
	
	const config_eks = {
		type: 'doughnut',
		data: data_eks,
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Jenis Kelamin Responden Eksternal'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
			}
		},
		
	};
	
	const config_old = {
		type: 'bar
		data: data_eks,
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Jenis Kelamin Responden Eksternal'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
			}
		},
		
	};
	
	const myChart = new Chart(
		document.getElementById('myChart'),
		config
	);
	
	const myChart_eks = new Chart(
		document.getElementById('myChartEks'),
		config_eks
	);
	
	const old_in = new Chart(
		document.getElementById('old'),
		config_old
	);
//*/
</script>
	
	
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
	<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
	
	<script id="details-template" type="text/x-handlebars-template">
		<div class="label label-info">Responden @{{answer}}</div>
		<table class="table details-table" id="details-@{{code}}">
			<thead>
			<tr>
				<th>ID</td>
				<th>Unit Kerja</td>
				<th>Jumlah Responden</td>
			</tr>
			</thead>
		</table>
	</script>
	
    <script>
        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
		
		var template = Handlebars.compile($("#details-template").html());
		var table = $('#eksternal-table').DataTable({
				responsive: true,
				processing: true,
				serverSide: true,
				//deferRender: true,
				//autoWidth: false,
				ajax: '{{ route('module.category.data') }}',
				columns: [
					{data: 'DT_RowIndex', name : 'DT_RowIndex', orderable:false},
					{data: 'answer', name: 'answer'},
					{data: 'instansi_count', name: 'instansi_count'},
					{
						"className"		: 'details-control',
						"corderable"	: false,
						"searchable"	: false,
						"data"			: null,
						"defaultContent": ''
					},
					//{data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
				],
				//order: [[1, 'asc']]
		});
		var inttable = $('#internal-table').DataTable({
				responsive: true,
				processing: true,
				serverSide: true,
				
				//autoWidth: false,
				ajax: '{{ route('module1.category.data') }}',
				columns: [
					{data: 'DT_RowIndex', name : 'DT_RowIndex', orderable:false},
					{data: 'answer', name: 'answer'},
					{data: 'internal_count', name: 'internal_count'},
					{
						"className"		: 'details-control',
						"corderable"	: false,
						"searchable"	: false,
						"data"			: null,
						"defaultContent": ''
					},
					//{data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
				],
				//order: [[1, 'asc']]
		});
		function initTable(tableId, data){
			var code_id = data['code'];
			var url = '{{ route('module1.detail.data', ":id") }}';
			url = url.replace(':id', code_id);
			
			$('#' + tableId).DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: url,
					data: { id: code_id},
				},
				columns: [
					{ data: 'code', name: 'code' },
					{ data: 'answer', name: 'answer' },
					{ data: 'dalem_count', name: 'dalem_count' },
				]
			});
			//console.log(code_id);
			console.log(url);
			itung += 1;
		}
		function initTableEksternal(tableId, data){
			var code_id = data['code'];
			var url = '{{ route('module.detail.data', ":id") }}';
			url = url.replace(':id', code_id);
			
			$('#' + tableId).DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: url,
					data: { id: code_id},
				},
				columns: [
					{ data: 'code', name: 'code' },
					{ data: 'answer', name: 'answer' },
					{ data: 'unit_count', name: 'unit_count' },
				]
			});
			//console.log(code_id);
			console.log(url);
			itung += 1;
		}
		var itung = 0;
		
		$('#internal-table tbody').on('click', 'td.details-control', function() {
			
			//console.log(itung);
			var tr = $(this).closest('tr');
			var row = inttable.row(tr);
			var tableId = 'details-' + row.data().code;
			
			if(row.child.isShown()){
				row.child.hide();
				tr.removeClass('shown');
			}else{
				row.child(template(row.data())).show();
				initTable(tableId, row.data());
				tr.addClass('shown');
				tr.next().find('td').addClass('no-padding bg-gray');
			}
		});
		
		$('#eksternal-table tbody').on('click', 'td.details-control', function() {
			
			console.log(itung);
			var tr = $(this).closest('tr');
			var row = table.row(tr);
			var tableId = 'details-' + row.data().code;
			
			if(row.child.isShown()){
				row.child.hide();
				tr.removeClass('shown');
			}else{
				row.child(template(row.data())).show();
				initTableEksternal(tableId, row.data());
				tr.addClass('shown');
				tr.next().find('td').addClass('no-padding bg-gray');
			}
		});
    </script>
@endpush