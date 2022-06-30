<script>
$(document).ready(function() {

	$('[data-rel=tooltip]').tooltip({container:'body'});
	$('[data-rel=popover]').popover({container:'body'});

	$('#id-input-file').ace_file_input({
		no_file: 'Sin archivos',
		btn_choose: 'Seleccionar',
		btn_change: 'Cambiar',
		uploadMultiple: true,
		parallelUploads: 10,
		droppable: true,
		//whitelist:'xlxs'
		//blacklist:'exe|php'
		//onchange:''
		//
	}).on('change', function() {
    var files = $(this).data('ace_input_files');
    if(files.length > 1) $(this).ace_file_input('show_file_list',[files.length + ' Archivos seleccionados']);
    	else $(this).ace_file_input('show_file_list',[files[0].name]);

 });

	
	$('.destroyer').click(function() {
		$(this).parent('div').remove();
	});	
});

</script>
