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
	
	var usia_data_intern = {{ Js::from($data_usia_intern) }};
	var usia_labels_intern = {{ Js::from($labels_usia_intern) }};
	
	const old = {
		labels : usia_labels_intern,
		datasets : [
			{
				labels : 'My First dataset',
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)'
				],
				borderColor: [
					'rgb(255, 99, 133)',
					'rgb(255, 159, 65)',
					'rgb(255, 205, 87)',
					'rgb(75, 192, 193)',
					'rgb(54, 162, 236)',
					'rgb(153, 102, 256)',
					'rgb(201, 203, 208)'
				],
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
				
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)'
				],
				borderColor: [
					'rgb(255, 99, 133)',
					'rgb(255, 159, 65)',
					'rgb(255, 205, 87)',
					'rgb(75, 192, 193)',
					'rgb(54, 162, 236)',
					'rgb(153, 102, 256)',
					'rgb(201, 203, 208)'
				],
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
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)'
				],
				borderColor: [
					'rgb(255, 99, 133)',
					'rgb(255, 159, 65)',
					'rgb(255, 205, 87)',
					'rgb(75, 192, 193)',
					'rgb(54, 162, 236)',
					'rgb(153, 102, 256)',
					'rgb(201, 203, 208)'
				],
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
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)'
				],
				borderColor: [
					'rgb(255, 99, 133)',
					'rgb(255, 159, 65)',
					'rgb(255, 205, 87)',
					'rgb(75, 192, 193)',
					'rgb(54, 162, 236)',
					'rgb(153, 102, 256)',
					'rgb(201, 203, 208)'
				],
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
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)'
				],
				borderColor: [
					'rgb(255, 99, 133)',
					'rgb(255, 159, 65)',
					'rgb(255, 205, 87)',
					'rgb(75, 192, 193)',
					'rgb(54, 162, 236)',
					'rgb(153, 102, 256)',
					'rgb(201, 203, 208)'
				],
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
//*/
</script>