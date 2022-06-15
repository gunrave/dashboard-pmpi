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
        <div class="col-md-12">
			<div class="card"> 
				<div class="card-body">
					<table id="category-table" class="table table-hover table-bordered table-stripped table-responsive">
						<thead>
							<tr>
								<th></th>
							   <th>No.</th>
							   <!--<th>Kelompok</th>
							   
								<th>ID</th>-->
								<th>Unit Kerja/Satker</th>
								<th>Total Responden</th>
								<!--<th width="200" class="text-center">Action</th>-->
							</tr>
						</thead>
					</table>
				</div>
			</div>
        </div>
    </div>
@stop

@push('js')
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
		var table = $('#category-table').DataTable({
				processing: true,
				serverSide: true,
				//autoWidth: false,
				ajax: '{{ route('module.category.data') }}',
				columns: [
					{
						"className"		: 'details-control',
						"corderable"	: false,
						"searchable"	: false,
						"data"			: null,
						"defaultContent": ''
					},
					{data: 'DT_RowIndex', name : 'DT_RowIndex'},
					{data: 'answer', name: 'answer'},
					{data: 'instansi_count', name: 'instansi_count'},
					
					//{data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
				],
				paging: false,
				order: [[1, 'asc']]
		});
		function initTable(tableId, data){
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
		
		$('#category-table tbody').on('click', 'td.details-control', function() {
			
			var tr = $(this).closest('tr');
			var row = table.row(tr);
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
    </script>
@endpush