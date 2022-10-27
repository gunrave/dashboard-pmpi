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
	
})