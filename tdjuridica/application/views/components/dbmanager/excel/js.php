<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('.chosen-select').chosen({allow_single_deselect:true});
	
	$('#data_excel').ace_file_input({
		no_file: 'Sin excel ...',
		btn_choose: 'Seleccionar',
		btn_change: 'Cambiar',
		droppable: false,
		onchange: null,
		thumbnail: false, //| true | large
		//whitelist:'xlxs'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
	
});
</script>