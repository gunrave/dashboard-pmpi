@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('plugins.Chartjs-plugin-datalabels', true)
@section('title', 'Demografi Responden PMPI')
@section('content_header')	
    <h1 class="m-0 text-dark">Demografi Responden PMPI</h1>
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
				<div class="card-header">
					<div class="card-title">
						Internal
					</div>
					<div class="card-tools">
						<ul class="nav nav-pills ml-auto" id="pills-tab" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="pills-jk-tab" data-toggle="pill" href="#pills-jk" role="tab" aria-controls="pills-jk" aria-selected="true">Gender</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-usia-tab" data-toggle="pill" href="#pills-usia" role="tab" aria-controls="pills-usia" aria-selected="false">Usia</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-pendidikan-tab" data-toggle="pill" href="#pills-pendidikan" role="tab" aria-controls="pills-pendidikan" aria-selected="false">Pendidikan</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-gol-tab" data-toggle="pill" href="#pills-gol" role="tab" aria-controls="pills-gol" aria-selected="false">Golongan</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-jab-tab" data-toggle="pill" href="#pills-jab" role="tab" aria-controls="pills-jab" aria-selected="false">Jabatan</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-masakerja-tab" data-toggle="pill" href="#pills-masakerja" role="tab" aria-controls="pills-masakerja" aria-selected="false">Masa Kerja</a>
						  </li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="pills-jk" role="tabpanel" aria-labelledby="pills-jk-tab">
							<canvas id="myChart"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-usia" role="tabpanel" aria-labelledby="pills-usia-tab">
							<canvas id="old"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-pendidikan-tab">
							<canvas id="pendidikan"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-gol" role="tabpanel" aria-labelledby="pills-gol-tab">
							<canvas id="gol"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-jab" role="tabpanel" aria-labelledby="pills-jab-tab">
							<canvas id="jabatan"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-masakerja" role="tabpanel" aria-labelledby="pills-masker-tab">
							<canvas id="masker"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<div class="card-title">
						Eksternal
					</div>
					<div class="card-tools">
						<ul class="nav nav-pills ml-auto" id="pills-tab" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="pills-jenkel-tab" data-toggle="pill" href="#pills-jenkel" role="tab" aria-controls="pills-jenkel" aria-selected="true">Gender</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-frek-tab" data-toggle="pill" href="#pills-frek" role="tab" aria-controls="pills-frek" aria-selected="true">Frekuensi</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-edu-ex-tab" data-toggle="pill" href="#pills-edu-ex" role="tab" aria-controls="pills-edu" aria-selected="false">Pendidikan Tertinggi</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-pekerjaan-tab" data-toggle="pill" href="#pills-pekerjaan" role="tab" aria-controls="pills-pekerjaan" aria-selected="false">Pekerjaan</a>
						  </li>
						   <li class="nav-item">
							<a class="nav-link" id="pills-kepentingan-tab" data-toggle="pill" href="#pills-kepentingan" role="tab" aria-controls="pills-kepentingan" aria-selected="false">Kepentingan</a>
						  </li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="pills-jenkel" role="tabpanel" aria-labelledby="pills-jenkel-tab">
							<canvas id="myChartEks"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-frek" role="tabpanel" aria-labelledby="pills-frek-tab">
							<canvas id="frek"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-edu-ex" role="tabpanel" aria-labelledby="pills-edu-ex-tab">
							<canvas id="edu-ex"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-pekerjaan" role="tabpanel" aria-labelledby="pills-pekerjaan-tab">
							<canvas id="pekerjaan"></canvas>
						</div>
						<div class="tab-pane fade" id="pills-kepentingan" role="tabpanel" aria-labelledby="pills-kepentingan-tab">
							<canvas id="kepentingan"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@stop

@push('js')

<!--<script src="demografi.js"></script>
-->
<script>
	Chart.register(ChartDataLabels);
	/*
	Chart.defaults.set('plugins.datalabels', {
		color: '#FE777B'
	});
	*/
	var labels = {{ Js::from($labels_intern) }};
	var labels_eks = {{ Js::from($labels_ekstern) }};
	
	var users = {{ Js::from($data_intern) }};
	var users_eks = {{ Js::from($data_ekstern) }};
	

	
	const backColor = [
		'rgb(255, 99, 132)',
		'rgb(255, 159, 64)',
		'rgb(255, 205, 86)',
		'rgb(75, 192, 192)',
		'rgb(54, 162, 235)',
		'rgb(153, 102, 255)',
		'rgb(201, 203, 207)'
	];
	
	const bordColor =  [
		'rgb(255, 99, 133)',
		'rgb(255, 159, 65)',
		'rgb(255, 205, 87)',
		'rgb(75, 192, 193)',
		'rgb(54, 162, 236)',
		'rgb(153, 102, 256)',
		'rgb(201, 203, 208)'
	];
	
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
	
	var usia_data_intern = {{ Js::from($data_usia_intern) }};
	var usia_labels_intern = {{ Js::from($labels_usia_intern) }};
	
	const old = {
		labels : usia_labels_intern,
		datasets : [
			{
				labels : 'My First dataset',
				backgroundColor: backColor,
				borderColor: bordColor,
				data:usia_data_intern,
			}
		]
	};
	
	const config_old = {
		type: 'bar',
		data: old,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Usia Responden'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
			}
		},
		
	};
	
	var edu_data_intern = {{ Js::from($data_edu_intern) }};
	var edu_labels_intern = {{ Js::from($labels_edu_intern) }};
	
	const edu = {
		labels : edu_labels_intern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:edu_data_intern,
			}
		]
	};
	
	const config_edu = {
		type: 'bar',
		data: edu,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Pendidikan Terakhir Pegawai'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
		
	};
	
	var jab_data_intern = {{ Js::from($data_jab_intern) }};
	var jab_labels_intern = {{ Js::from($labels_jab_intern) }};
	
	const jab = {
		labels : jab_labels_intern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:jab_data_intern,
			}
		]
	};
	
	const config_jab = {
		type: 'bar',
		data: jab,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Jabatan Terakhir Pegawai'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
	};
	
	var gol_data_intern = {{ Js::from($data_gol_intern) }};
	var gol_labels_intern = {{ Js::from($labels_gol_intern) }};
	
	const gol = {
		labels : gol_labels_intern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:gol_data_intern,
			}
		]
	};
	
	const config_gol = {
		type: 'bar',
		data: gol,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Golongan Pegawai'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
		
	};
	
	var masker_data_intern = {{ Js::from($data_masker_intern) }};
	var masker_labels_intern = {{ Js::from($labels_masker_intern) }};
	
	const masker = {
		labels : masker_labels_intern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:masker_data_intern,
			}
		]
	};
	
	const config_masker = {
		type: 'bar',
		data: masker,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Masa Kerja Pegawai'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($pegawai->count()) }} pegawai'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
		
	};
	
	var frek_data_extern = {{ Js::from($data_frek_extern) }};
	var frek_labels_extern = {{ Js::from($labels_frek_extern) }};
	
	const frek = {
		labels : frek_labels_extern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:frek_data_extern,
			}
		]
	};
	
	const config_frek = {
		type: 'bar',
		data: frek,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Frekuensi berkunjung'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
		
	};
	
	var edu_data_extern = {{ Js::from($data_edu_extern) }};
	var edu_labels_extern = {{ Js::from($labels_edu_extern) }};
	
	const edu_ext = {
		labels : edu_labels_extern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:edu_data_extern,
			}
		]
	};
	
	const config_edu_ext = {
		type: 'bar',
		data: edu_ext,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Pendidikan Terakhir'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
		
	};
	
	var work_data_extern = {{ Js::from($data_work_extern) }};
	var work_labels_extern = {{ Js::from($labels_work_extern) }};
	
	const work = {
		labels : work_labels_extern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:work_data_extern,
			}
		]
	};
	
	const config_work = {
		type: 'bar',
		data: work,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Pendidikan Terakhir'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
	};
	
	var penting_data_extern = {{ Js::from($data_penting_extern) }};
	var penting_labels_extern = {{ Js::from($labels_penting_extern) }};
	
	const penting = {
		labels : penting_labels_extern,
		datasets : [
			{
				backgroundColor: backColor,
				borderColor: bordColor,
				data:penting_data_extern,
			}
		]
	};
	
	const config_penting = {
		type: 'bar',
		data: penting,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Pendidikan Terakhir'
				},
				subtitle: {
					display: true,
					text: 'Total : {{ number_format($responden->count()) }} responden'
				},
				legend:{
					labels: {
						generateLabels: 'Pendidikan Terakhir pada responden'
					}
				}
			}
		},
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
				datalabels:{
					color: '#36A2EB'
				}
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
	
	const pendidikan = new Chart(
		document.getElementById('pendidikan'),
		config_edu
	);
	
	const jabatan = new Chart(
		document.getElementById('jabatan'),
		config_jab
	);
	
	const golongan = new Chart(
		document.getElementById('gol'),
		config_gol
	);
	
	const masakerja = new Chart(
		document.getElementById('masker'),
		config_masker
	);
	
	const frekuensi = new Chart(
		document.getElementById('frek'),
		config_frek
	);
	
	const edukasi_external = new Chart(
		document.getElementById('edu-ex'),
		config_edu_ext
	);
	
	const pekerjaan = new Chart(
		document.getElementById('pekerjaan'),
		config_work
	);
	
	const kepentingan = new Chart(
		document.getElementById('kepentingan'),
		config_penting
	);
//*/
</script>
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
@endpush