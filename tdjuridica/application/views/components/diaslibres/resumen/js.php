<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>

<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootbox.js') ?>"></script>

<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>

<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.es.js') ?>"></script>

<script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>

		
 
<script>


var infoModal = null;
 
var estadoBotonTrabajando = false;
var estadoBotonDescansando = false;
var estadoBotonAcumulado = false;
var estadoBotonInactivo = false;

var numeroDescansando = 0;
var numeroTrabajando = 0;
var numeroAcumulado = 0;
var numeroInactivo = 0;

$(document).ready(function() {
 	var mesesUsados = <?= $mesesUsados ?>;
 	
	var myChart = $('#myChart').css({'width':'100%' , 'height':'220px'});
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: mesesUsados[1],
	        datasets: [{
	            label: '# personas en vacaciones',
	            data: mesesUsados[0],
	            backgroundColor: 'rgba(255, 99, 132, 0.2)',
	            borderColor: 'rgba(255, 99, 132, 1)',
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});
				
				
 
 	var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "data": <?= $datatable ?>,
        "createdRow": function( row, data, dataIndex){
			        	if(data.ACUMULADO == '1') numeroAcumulado += 1;
		            },
		"columnDefs": [
            {
            	"title": 'id',
            	"data": 'ID',
                "targets": 0,
                "visible": false
            },
            {
            	"title": 'RUN',
            	"data": 'RUT',
                "targets": 1,
                "render": function ( data, type, row ) {
                	num = row.RUT;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
					texto = num +'-'+ row.DIGITO;
					if(row.DESCANSANDO) {
						numeroDescansando += 1;
						return '<span class="label label-info" >'+ texto +'</span>';
					}	else {
						
							if(row.ACTIVO){
								numeroTrabajando +=1;
								return texto;
							}	else {
									numeroInactivo += 1;
									return '<span class="label label-warning" >'+ texto +'</span>';
								}
						}
                		
                }
            },
            {
            	"title": 'Apellido paterno',
            	"data": 'APELLIDO_PATERNO',
                "targets": 2,
            },
            {
            	"title": 'Apellido materno',
            	"data": 'APELLIDO_MATERNO',
                "targets": 3,
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRES',
                "targets": 4,
            },
            {
            	"title": 'Centro',
            	"data": 'CENTRO',
                "targets": 5,
            },
            {
            	"title": 'Feriados Legales Disponibles',
            	"data": 'FERIADOS_LEGALES',
                "targets": 6,
            },
            {
            	"title": 'Días Administrativos Disponibles',
            	"data": 'DIAS_LIBRES',
                "targets": 10,
            },
            {
            	"title": 'Sin goce sueldo',
            	"data": 'PSGS',
                "targets": 11,
                "visible": false
            },
            {
                "title": '+',
                "class": "details-control",
                "orderable": false,
                "targets": 12,
                "render": function ( data, type, row ) {
                	return '<a class="details-control"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                }

            },
            {
            	"title": 'DESCANSANDO',
            	"data": 'DESCANSANDO',
                "targets": 7,
                "visible": false
            },
            {
            	"title": 'ACUMULADO',
            	"data": 'ACUMULADO',
                "targets": 8,
                "visible": false
            },
            {
            	"title": 'ACTIVO',
            	"data": 'ACTIVO',
                "targets": 9,
                "visible": false
            },
        ],
		"order": [[ 2, "asc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	<?php if ($this->ion_auth->in_group(array('dlibresValidador'))): ?>
	var myTable3 = $('#dynamic-table3').DataTable( {
        "bAutoWidth": false,
        "ajax": {
		            "url": "<?= site_url('DiasLibres/getPermisosValidar') ?>",
		            "type": "GET"
		        },
		"columnDefs": [
            {
            	"title": 'id',
            	"data": 'ID',
                "targets": 0,
                "visible": true
            },
            {
            	"title": 'RUN',
            	"data": 'RUT',
                "targets": 1,
                "render": function ( data, type, row ) {
                	num = row.RUT;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
					texto = num +'-'+ row.DIGITO;
					if(row.DESCANSANDO) {
						numeroDescansando += 1;
						return '<span class="label label-info" >'+ texto +'</span>';
					}	else {
							numeroTrabajando +=1;
							return texto;
						}
                		
                }
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRE',
                "targets": 2,
                "render": function ( data, type, row ) {
                	return row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO;
                }
            },
            {
            	"title": 'Centro',
            	"data": 'CENTRO',
                "targets": 3,
            },
            {
            	"title": 'Tipo',
            	"data": 'PERMISO',
                "targets": 4,
            },
            {
            	"title": 'Días',
            	"data": 'DIAS',
                "targets": 5,
            },
            {
            	"title": 'Inicio',
            	"data": 'INICIO',
                "targets": 6,
                "render": function (data, type, row){
		                	return moment(data).format("DD/MM/YYYY");	
		                },
            },
            {
            	"title": 'Termino',
            	"data": 'TERMINO',
                "targets": 7,
                "render": function (data, type, row){
		                	return moment(data).format("DD/MM/YYYY");	
		                },
            },
            {
	            "title": 'Documento',
            	"data": 'DOCUMENTO',
                "targets": 8,
                "render": function ( data, type, row ) {
                	if(!data){
                		return 'No Aplica';
                	}	else{
                			return '<a class="btn btn-minier btn-primary" href="'+ data +'" target="_blank">\
									<i class="ace-icon fa fa-download bigger-110"></i>\
									Descargar\
								</a>';
                		}
                }
            },
            {
                "title": '+',
                "orderable": false,
                "targets": 9,
                "render": function ( data, type, row ) {
                	return '<div class="hidden-sm hidden-xs action-buttons">\
                				<a class="blue" href="#" title="Aceptar" data-toggle="modal" data-target="#acceptModal" data-id="' + row.ID + '" data-nombres="' + row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO + '" data-dias="' + row.DIAS + '"><i class="ace-icon fa fa-check bigger-130"></i></a>\
                				<a class="red" title="Eliminar" href="#" data-toggle="modal" data-target="#deleteModal" data-id="' + row.ID + '" data-nombres="' + row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO + '" data-dias="' + row.DIAS + '"><i class="ace-icon fa fa-times bigger-130"></i></a>\
                			</div>';
                }

            }
        ],
		"order": [[ 0, "desc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al portapapeles</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"exportOptions": {
				"columns": ':not(:first):not(:last)'
			}
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"autoPrint": true,
			"message": '<h2>Días Libres</h2>',
			"exportOptions": {
				"columns": ':not(:first):not(:last)'
			}
		  }
		]
	} );
	
	var defaultCopyAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
	
	myTable.buttons().container().appendTo( $('.tableTools-container') );
	
	$('#deleteModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); 
		
		var id = button.data('id');
		var nombres = button.data('nombres');
		var dias = button.data('dias');
		
		var modal = $(this);	
		
		modal.find('.delete-modal-nombres').text(nombres);
		modal.find('.delete-modal-dias').text(dias);
		modal.find('#deleteButton').attr('onclick', "btnRemove(" + id + ")");
	});
	
	$('.loading-delete-btn').on(ace.click_event, function () {
		var btn = $(this);
		btn.button('loading');
	});
	
	$('#acceptModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); 
		
		var id = button.data('id');
		var nombres = button.data('nombres');
		var dias = button.data('dias');
		
		var modal = $(this);	
		
		modal.find('.accept-modal-nombres').text(nombres);
		modal.find('.accept-modal-dias').text(dias);
		modal.find('#acceptButton').attr('onclick', "btnAccept(" + id + ")");
	});
	
	$('.loading-accept-btn').on(ace.click_event, function () {
		var btn = $(this);
		btn.button('loading');
	});
				
	<?php endif; ?>
	
	
	var detailRows = [];
 
	$('#dynamic-table tbody').on( 'click', 'tr td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = myTable.row( tr );
	        var idx = $.inArray( tr.attr('id'), detailRows );
			
	        if ( row.child.isShown() ) {
	            tr.removeClass( 'details' );
	            row.child.hide();
	 
	            // Remove from the 'open' array
	            detailRows.splice( idx, 1 );
	        }
	        else {
	            tr.addClass( 'details' );
	            row.child( rowChildAdvanceInformation( row.data(), row.index() ) ).show();
	 
	            // Add to the 'open' array
	            if ( idx === -1 ) {
	                detailRows.push( tr.attr('id') );
	            }
	            
	            var myTable2 = $('#dynamic-table2' + row.data().ID).DataTable( {
			        "bAutoWidth": false,
			        "ajax": {
			            "url": "<?= site_url('DiasLibres/getPermisos/') ?>" + row.data().RUT,
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
			            	"iDataSort": 6,
			                "targets": 3,
			                "render": function (data, type, row){
			                	return moment(data).format("DD/MM/YYYY");	
			                },
			            },
			            {
			            	"title": 'Termino',
			            	"data": 'TERMINO',
			            	"iDataSort": 7,
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
			            {
			            	"title": 'FILTER_DATE_INICIO',
			            	"data": 'INICIO',
			                "targets": 6,
			                "visible": false
			            },
			            {
			            	"title": 'FILTER_DATE_TERMINO',
			            	"data": 'TERMINO',
			                "targets": 7,
			                "visible": false
			            }
			        ],
					"order": [[ 0, "desc" ]],
					language: {
			        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
			    	}
				});
				
				
	        }
	        
	} );
    
	myTable.on( 'draw', function () {
	        $.each( detailRows, function ( i, id ) {
	            $('#'+id+' td.details-control').trigger( 'click' );
	        } );
	} );
	
	function rowChildAdvanceInformation ( d, indexRow ) {
		
		periodoAdicionalHTML = '';
		
		if( d.PERIODOS_ADICIONALES != false ){
			
			d.PERIODOS_ADICIONALES.forEach(function (element,index) {
				periodoAdicionalHTML += '<li>\
								        	    <b>Disponible '+element.año+': </b><span id="text_disponible_adicional'+indexRow+'_'+index+'">'+ element.disponible +'</span>&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados '+element.año+': </b><span id="text_utilizados_adicional'+indexRow+'_'+index+'">'+ (element.total - element.disponible) +'</span>\
		        						    </li>\
		        				';
			});
			
		}
		
	    return  '<div class="col-sm-4">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información feriados legales</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul>\
						        		    <li>\
								        	    <b>Disponible <?php echo date('Y'); ?>: </b><span id="text_disponible_actual'+indexRow+'">'+ d.PERIODO_ACTUAL +'</span>&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados <?php echo date('Y'); ?>: </b><span id="text_utilizados_actual'+indexRow+'">'+ d.USADOS_ACTUAL +'</span>\
		        						    </li>\
		        						    <li>\
								        	    <b>Disponible <?php echo (int)date('Y') - 1; ?>: </b><span id="text_disponible_anterior'+indexRow+'">'+ d.PERIODO_ANTERIOR +'</span>&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados <?php echo (int)date('Y') - 1; ?>: </b><span id="text_utilizados_anterior'+indexRow+'">'+ d.USADOS_ANTERIOR +'</span>\
		        						    </li>\
		        						    ' + periodoAdicionalHTML + 
		        					    '</ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>\
	    		<div class="col-sm-4">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información de cargo</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul>\
						        		    <li>\
								        	    <b>Cargo: </b>'+ d.CARGO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Categoria: </b>'+ d.CATEGORIA +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Nivel: </b>'+ d.NIVEL +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Fecha reconocimiento: </b>'+ d.FECHA_RECONOSIMIENTO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Inicio contrato: </b>'+ d.INICIO_CONTRATO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Termino contrato: </b>'+ d.TERMINO_CONTRATO +'\
		        						    </li>\
		        					    </ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>\
	        	<?php if ($this->ion_auth->in_group(array('dlibresAdd'))): ?>
	        	<div class="col-sm-4">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Registrar...</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12 center">\
			        					<button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#addModalFL" data-index="'+ indexRow +'">\
											<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>\
											Feriado legal\
										</button>\
										<button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#addModalDA" data-index="'+ indexRow +'">\
											<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>\
											Dia administrativo\
										</button>\
										<?php if ($this->ion_auth->in_group('developed')): ?>\
										<a  href="<?= site_url('DiasLibres/persona/')?>'+ d.RUT +'/#inicioFormId" class="btn btn-white btn-info btn-bold">\
											<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>\
											Otros\
										</a>\
										<?php endif; ?>\
		        				    </div>\
		        			    </div>\
		        			    <div class="row">\
			        				<div class="col-sm-12 center">\
			        					<a href="<?= site_url('DiasLibres/persona/')?>'+ d.RUT +'" class="btn btn-white btn-info">\
											<i class="ace-icon glyphicon glyphicon-user  bigger-120 blue"></i>\
											Vista completa\
										</a>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>\
	        	<?php endif; ?>
	        	<div class="row">\
				    <table id="dynamic-table2'+ d.ID +'" class="table table-striped table-bordered table-hover compact"></table>\
				</div>';
	}
	
	$('#numeroTrabajando').text(numeroTrabajando);
	$('#numeroDescansando').text(numeroDescansando);
	$('#numeroAcumulado').text(numeroAcumulado);
	$('#numeroInactivo').text(numeroInactivo);
	
	$('#divTrabajando').click(function(){
		if(estadoBotonTrabajando){
			resetSearch();
		}	else {
				resetSearch();
				$('#divTrabajando').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(9).search('(1)', true).draw();
				estadoBotonTrabajando = true;
			}
	});
	
	$('#divDescansando').click(function(){
		if(estadoBotonDescansando){
			resetSearch();
		}	else {
				resetSearch();
				$('#divDescansando').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(7).search('(1)', true).draw();
				estadoBotonDescansando = true;
			}
	});
	
	$('#divAnterior').click(function(){
		if(estadoBotonAcumulado){
			resetSearch();
		}	else{
				resetSearch();
				$('#divAnterior').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(8).search('(1)', true).draw();
				estadoBotonAcumulado = true;
				
			}
	});
	
	$('#divInactivo').click(function(){
		if(estadoBotonInactivo){
			resetSearch();
		}	else{
				resetSearch();
				$('#divInactivo').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(9).search('(0)', true).draw();
				estadoBotonInactivo = true;
				
			}
	});
	
	function resetSearch(){
		myTable.columns().search("").draw();
		
		estadoBotonTrabajando = false;
		$('#divTrabajando').css("background-color", "rgb(255, 255, 255)");
		
		estadoBotonDescansando = false;
		$('#divDescansando').css("background-color", "rgb(255, 255, 255)");
		
		estadoBotonAcumulado = false;
		$('#divAnterior').css("background-color", "rgb(255, 255, 255)");
		
		estadoBotonInactivo = false;
		$('#divInactivo').css("background-color", "rgb(255, 255, 255)");
		
	}
	
	//$('#divTrabajando').click();
	
});

<?php if ($this->ion_auth->in_group(array('dlibresValidador'))): ?>
function btnRemove(id) {
	$.ajax({
		url: "<?= site_url('DiasLibres/rechazarPermiso') ?>/" + id,
		type: 'get',				
		dataType: 'json',
		success:function(response) {
			
			if(response !== 'ERROR') {
				$('#deleteModal').modal('hide');
				setTimeout(function () {
					$('.loading-delete-btn').button('reset')
				}, 500);
				
				$('#dynamic-table3').DataTable().ajax.reload(null, false);
				$.gritter.add({
					title: 'Rechazo exitoso',
					text: 'Se a rechazado el permiso',
					class_name: 'gritter-success'
				});
			}	else {
					$.gritter.add({
						title: 'Algo ocurrio mal',
						text: 'Algo inesperado ocurrio, favor recargar la pagina o notificar a administración',
						class_name: 'gritter-warning'
					});
				}
				
				
		}, // /succes
		error: function (jqXHR, textStatus, errorThrown)
    	{
    		$.gritter.add({
				title: 'Error rechazar',
				text: 'No se ha podido rechazar.',
				class_name: 'gritter-error'
			});
			$('#deleteModal').modal('hide');
			setTimeout(function () {
				$('.loading-delete-btn').button('reset')
			}, 500);
			console.log(errorThrown);
    	} // /error
	});
}

function btnAccept(id) {
	$.ajax({
		url: "<?= site_url('DiasLibres/aceptarPermiso') ?>/" + id,
		type: 'get',				
		dataType: 'json',
		success:function(response) {
			
			if(response !== 'ERROR') {
				$('#acceptModal').modal('hide');
				setTimeout(function () {
					$('.loading-accept-btn').button('reset')
				}, 500);
				
				$('#dynamic-table3').DataTable().ajax.reload(null, false);
				$.gritter.add({
					title: 'Aprobación exitosa',
					text: 'Se a Aprovado el permiso',
					class_name: 'gritter-success'
				});
			}	else {
					$.gritter.add({
						title: 'Algo ocurrio mal',
						text: 'Algo inesperado ocurrio, favor recargar la pagina o notificar a administración',
						class_name: 'gritter-warning'
					});
				}
		}, // /succes
		error: function (jqXHR, textStatus, errorThrown)
    	{
    		$.gritter.add({
				title: 'Error aceptar',
				text: 'No se ha podido aceptar.',
				class_name: 'gritter-error'
			});
			$('#deleteModal').modal('hide');
			setTimeout(function () {
				$('.loading-delete-btn').button('reset')
			}, 500);
			console.log(errorThrown);
    	} // /error
	});
}
<?php endif; ?>	

function removerHasError(){
		document.getElementById("ERROR_FORM_VALIDATOR").style.display = "none";
		document.getElementById("ERROR_SYSTEM").style.display = "none";
		document.getElementById("ERROR_SAVE_DB").innerHTML = '';
		document.getElementById("diasForm").classList.remove("has-error");
    	document.getElementById("documento").classList.remove("has-error");
	}
var index;	
var idTablaPrincipal;
var modal;

$('#addModalFL').on('show.bs.modal', function (event) {
	
	$("#formFL")[0].reset();
	modal = $(this);
	index = $(event.relatedTarget).data('index');
	
	myTable = $('#dynamic-table').DataTable();
	data = myTable.row(index).data();
	idTablaPrincipal = data.ID;
	var totalDias = data.FERIADOS_LEGALES;
	modal.find('#nombre').text(data.NOMBRES +' '+ data.APELLIDO_PATERNO +' '+ data.APELLIDO_MATERNO);
	
	num = data.RUT;
   	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
	num = num.split('').reverse().join('').replace(/^[\.]/,'');
	modal.find('#run').text(num +'-'+ data.DIGITO);
	
	modal.find('#dias').text(totalDias);
	
    $('#id-input-file').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false,
		});
	$('#id-input-file').ace_file_input('reset_input');
	$('#contarDiasText').text('');
	
	removerHasError();
});

$("#formFL").submit(function(e){
	e.preventDefault();

	submit = $('#submitButton');
	
	submit.prop('disbaled', true);
	submit.prop('value', 'Procesando..');
	
	myTable = $('#dynamic-table').DataTable();
	data = myTable.row(index).data();
	ajaxSubmit(data, this, myTable, idTablaPrincipal, modal);

    
});
    
function ajaxSubmit(data, form, myTable, idTablaPrincipal, modal){
	$.ajax({																			//Envia los datos por ajax
        url: "<?= site_url('DiasLibres/addFL/') ?>" + data.RUT,
        type: "POST",
        data:  new FormData(form),														//envia por post el formulario del boton submit
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
        	//antes de enviar, oculta los mensajes de erorres 
        	removerHasError();
        	document.getElementById("skinerOnRegister").style.display = "";
        },
        success: function(response){
        	document.getElementById("skinerOnRegister").style.display = "none";
        	console.log(response);
            var	data = JSON.parse(response);
            
            
            //Dependiendo del mensaje setiado en el controlador, genera notificaciónes
            if(data[0] === 'SUCCESSFUL'){								//se guardaron los datos y mando mail
                record = JSON.parse(data[1]);
                //Actualizar datos datatable
                infoUpdate = data[3];
                myTable.table().cell({row:index, column:6}).data(infoUpdate.disponibles);
                if(infoUpdate.disponiblesPeriodoActual != null) $('#text_disponible_actual' + index).text(infoUpdate.disponiblesPeriodoActual);
                if(infoUpdate.utilizadosPeriodoActual != null) $('#text_utilizados_actual' + index).text(infoUpdate.utilizadosPeriodoActual);
                if(infoUpdate.disponiblesPeriodoAnterior != null) $('#text_disponible_anterior' + index).text(infoUpdate.disponiblesPeriodoAnterior);
                if(infoUpdate.utilizadosPeriodoAnterior != null) $('#text_utilizados_anterior' + index).text(infoUpdate.utilizadosPeriodoAnterior);
				if(infoUpdate.periodosAdicionales.length > 0) {
					for(x = 0; infoUpdate.periodosAdicionales.length > x; x++ ){
						$('#text_disponible_adicional' + index + '_' + x).text(infoUpdate.periodosAdicionales[x].disponible);
						$('#text_utilizados_adicional' + index + '_' + x).text(infoUpdate.periodosAdicionales[x].total - infoUpdate.periodosAdicionales[x].disponible);
					}
				}
                $.gritter.add({
                    title: 'Feriado legal registrado',
                    class_name: 'gritter-success'
                });
				
				$('#dynamic-table2' + idTablaPrincipal).DataTable().ajax.reload();
				modal.modal('toggle');
				//modal.modal('hide');
				
            }
            if(data[0] === "ERROR_FORM_VALIDATOR"){						//Algun campo de los revisados en el controlador no fue rellenado
                dateForm = JSON.parse(data[1]);
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_FORM_VALIDATOR").style.display = "";
                if(dateForm['inicio'] === '') document.getElementById("diasForm").classList.add("has-error");
                if(dateForm['termino'] === '') document.getElementById("diasForm").classList.add("has-error");
                if(dateForm['documento'] === '') document.getElementById("documento").classList.add("has-error");
            }
            if(data[0] === "ERROR_RUN_NULL"){						//Algun campo de los revisados en el controlador no fue rellenado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SYSTEM").style.display = "";
                modal.find('#TEXT_ERROR_SYSTEM').text("Error en sistema, intentelo mas tarde.");
            }
            if(data[0] === "NOT_DAYS"){						//Algun campo de los revisados en el controlador no fue rellenado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SYSTEM").style.display = "";
                modal.find('#TEXT_ERROR_SYSTEM').text("La persona no le quedan días diasponibles.");
            }
            if(data[0] === "ERROR_MSN_BACK"){						//Algun campo de los revisados en el controlador no fue rellenado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SYSTEM").style.display = "";
                modal.find('#TEXT_ERROR_SYSTEM').text(data[1]);
            }
            if(data[0] === "ERROR_BACK"){
                record = JSON.parse(data[1]);
                console.log(record);
            }
        },
        error: function(e){												//Errores de sistema y codigo
        	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            console.log(e);
        }
    });
};

function removerHasErrorDA(){
	document.getElementById("ERROR_FORM_VALIDATOR_DA").style.display = "none";
	document.getElementById("ERROR_SYSTEM_DA").style.display = "none";
	document.getElementById("ERROR_SAVE_DB_DA").innerHTML = '';
	
	document.getElementById("inicioForm_da").classList.remove("has-error");
	document.getElementById("diasForm_da").classList.remove("has-error");
	document.getElementById("documento_da").classList.remove("has-error");
}

$('#addModalDA').on('show.bs.modal', function (event) {
	
	index = $(event.relatedTarget).data('index');
    modal = $(this);
    $("#formDA")[0].reset();
    
    myTable = $('#dynamic-table').DataTable();
	data = myTable.row(index).data();
	idTablaPrincipal = data.ID;
	
	modal.find('#nombre').text(data.NOMBRES +' '+ data.APELLIDO_PATERNO +' '+ data.APELLIDO_MATERNO);
	num = data.RUT;
   	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
	num = num.split('').reverse().join('').replace(/^[\.]/,'');
	modal.find('#run').text(num +'-'+ data.DIGITO);
	modal.find('#dias').text(data.DIAS_LIBRES);
    
    $('#id-input-file_da').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
	$('#id-input-file_da').ace_file_input('reset_input');

	removerHasErrorDA();
	//submit del boton guardar
    
});

$("#formDA").submit(function(e){
    e.preventDefault();
    $.ajax({																			//Envia los datos por ajax
        url: "<?= site_url('DiasLibres/addDA/') ?>"+ data.RUT,
        type: "POST",
        data:  new FormData(this),														//envia por post el formulario del boton submit
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
        	//antes de enviar, oculta los mensajes de erorres 
        	removerHasErrorDA();
        	document.getElementById("skinerOnRegister2").style.display = "";
        },
        success: function(response){
        	console.log(response);
        	document.getElementById("skinerOnRegister2").style.display = "none";
            var	data = JSON.parse(response);
            //Dependiendo del mensaje setiado en el controlador, genera notificaciónes
            if(data[0] === 'SUCCESSFUL'){	
				//se guardaron los datos y mando mail
                record = JSON.parse(data[1]);
                modal.modal('toggle');
                $.gritter.add({
                    title: 'Día administrativo registrado',
                    class_name: 'gritter-success'
                });
				
				$('#dynamic-table2' + idTablaPrincipal).DataTable().ajax.reload();
				myTable.table().cell({row:index, column:10}).data(data[2]);
            }
            if(data[0] === "ERROR_FORM_VALIDATOR"){						//Algun campo de los revisados en el controlador no fue rellenado
                dateForm = JSON.parse(data[1]);
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_FORM_VALIDATOR_DA").style.display = "";
                if(dateForm['inicio'] === '') document.getElementById("inicioForm_da").classList.add("has-error");
                if(dateForm['dias'] === '') document.getElementById("diasForm_da").classList.add("has-error");
                if(dateForm['documento'] === '') document.getElementById("documento_da").classList.add("has-error");
            }
            if(data[0] === "ERROR_RUN_NULL"){						//Algun campo de los revisados en el controlador no fue rellenado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SYSTEM_DA").style.display = "";
                modal.find('#TEXT_ERROR_SYSTEM_DA').text("Error en sistema, intentelo mas tarde.");
            }
            if(data[0] === "NOT_DAYS"){						//Algun campo de los revisados en el controlador no fue rellenado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SYSTEM_DA").style.display = "";
                modal.find('#TEXT_ERROR_SYSTEM_DA').text("La persona no le quedan días diasponibles.");
            }
        },
        error: function(e){												//Errores de sistema y codigo
        	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            console.log(e);
        }
    });
});

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
        		console.log(response);
            },
            error: function(e){											
                console.log(e);
            }
        });
    }
 });

 </script>
