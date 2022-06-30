<script>
	 $(document).ready(function() {
 	
 	$('#id-input-file_fl').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
	});
</script>