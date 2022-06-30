 <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
 <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
 <script>
 
 $('#contarDias').on(ace.click_event, function (event) {
 	inicio =  $('#dataInicio').val();
    termino =  $('#dataTermino').val();
    if(inicio !== '' && termino !== ''){
    	$.ajax({																		
            url: "<?= site_url('DiasLibres/calcularFL/') ?>"+ inicio +'/'+ termino,
            type: "GET",
            beforeSend : function(){
				document.getElementById("skinerOn").style.display = "";
            },
            success: function(response){
                $('#contarDiasText').text(response);
                document.getElementById("skinerOn").style.display = "none";
            },
            error: function(e){											
                console.log(e);
            }
        });
    }
 });
 
 $(document).ready(function() {
 	
 	$('#id-input-file_fl').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
	$('#id-input-file_da').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
		
	$('#id-input-file_otros').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
		
 	var myTable = $('#dynamic-table').DataTable( {
			        "bAutoWidth": false,
			        "ajax": {
			            "url": "<?= site_url('DiasLibres/getPermisos/') ?>" + "<?= $rut ?>",
			            "type": "GET"
			        },
			        "createdRow": function( row, data, dataIndex){
			        	if(data.PERMISO == 'Día Administrativo') $(row).addClass('orange');
			        	if(data.PERMISO == 'Feriado Legal') $(row).addClass('blue');
		            },
					"columnDefs": [
			            {
			            	"title": 'id',
			            	"data": 'ID',
			                "targets": 0,
			                "visible": false
			            },
			            {
			            	"title": 'Permiso',
			            	"data": 'PERMISO',
			                "targets": 1,
			            },
			            {
			            	"title": 'Dias',
			            	"data": 'DIAS',
			                "targets": 2,
			            },
			            {
			            	"title": 'Inicio',
			            	"data": 'INICIO',
			                "targets": 3,
			                "render": function (data, type, row){
			                	return moment(data).format("DD/MM/YYYY");	
			                },
			            },
			            {
			            	"title": 'Termino',
			            	"data": 'TERMINO',
			                "targets": 4,
			                "render": function (data, type, row){
			                	if(data == '') 	return 'No aplica';	
			                		else return moment(data).format("DD/MM/YYYY");
			                },
			            },
			            {
				            "title": 'Documento',
			            	"data": 'DOCUMENTO',
			                "targets": 5,
			                "render": function ( data, type, row ) {
			                	if(data === '*'){
			                		return 'No Aplica';
			                	}	else{
			                			return '<a class="btn btn-minier btn-primary" href="'+ data +'" target="_blank">\
												<i class="ace-icon fa fa-download bigger-110"></i>\
												Descargar\
											</a>';
			                		}
			                }
			            },
			        ],
					"order": [[ 0, "desc" ]],
					language: {
			        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
			    	}
				});
});
 </script>
