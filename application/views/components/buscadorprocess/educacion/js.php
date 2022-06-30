<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>


<script>

$(document).ready(function() {
    
    var filtroActivos = "<?php
							if(empty($indicadores[3])) echo "";
								else{
									$filtro = "(";
									foreach($indicadores[3] as $key => $value){
										$filtro .= $value['APP_NUMBER']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroVencen7 = "<?php
							if(empty($indicadores[4])) echo "";
								else{
									$filtro = "(";
									foreach($indicadores[4] as $key => $value){
										$filtro .= $value['APP_NUMBER']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
						
	var estadoBotonActivas = false;
	var estadoBoton7 = false;
	
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "data": <?= $indicadores[8] ?>,
		"columnDefs": [
            {
            	"title": 'APP_UID',
            	"data": 'APP_UID',
                "targets": 0,
                "visible": false
            },
            {
            	"title": 'N°Caso',
            	"data": 'APP_NUMBER',
                "targets": 1,
                "render": function ( data, type, row ) {
                    if(row.PRO_TITLE[0] == 1) return '<span class="label label-info">' + data + '</span>';
                    if(row.PRO_TITLE[0] == 2) return '<span class="label label-success">' + data + '</span>';
                    if(row.PRO_TITLE[0] == 3) return '<span class="label label-yellow">' + data + '</span>';
                    if(row.PRO_TITLE[0] == 0) return '<span class="label label-default">' + data + '</span>';
                }
            },
            {
            	"title": 'Estado/creación',
            	"data": 'APP_STATUS',
                "targets": 2,
                "render": function ( data, type, row ) {
                	if(data == 'TO_DO') {
                		return 'En curso ' + moment(row.APP_CREATE_DATE).format("DD/MM/YYYY");
                	} else if(data == 'COMPLETED') return 'Completado ' + moment(row.APP_CREATE_DATE).format("DD/MM/YYYY");
                	return data;
                }
            },
            {
            	"title": 'Establecimiento',
            	"data": 'ESTABLECIMIENTO_SOLICITANTE_LABEL',
                "targets": 3,
            },
            {
            	"title": 'RUN Func',
            	"data": 'RUT_REEMPLAZADO_LABEL',
                "targets": 4
            },
            {
            	"title": 'Nombre Funcionario',
            	"data": 'NOMBRES_REEMPLAZADO_LABEL',
                "targets": 5,
                "render": function ( data, type, row ) {
                	return row.NOMBRES_REEMPLAZADO_LABEL + ' '+ row.APELLIDOS_REEMPLAZADO_LABEL;
                }
            },
            {
            	"title": 'RUN Rem',
            	"data": 'FUNCIONARIOS_RUT',
                "targets": 6,
                "render": function ( data, type, row ) {
                    if(row.PRO_TITLE[0] == 3) return 'No Aplica';
                        else return data;
                }
            },
            {
            	"title": 'Nombre Reemplazo',
            	"data": 'FUNCIONARIOS_NOMBRE',
                "targets": 7,
                "render": function ( data, type, row ) {
                    if(row.PRO_TITLE[0] == 3) return 'No Aplica';
                        else return row.FUNCIONARIOS_NOMBRE + ' '+ row.FUNCIONARIOS_APELLIDO;
                }
            },
            {
            	"title": 'Tipo',
            	"data": 'TIPO',
                "targets": 8,
                "render": function ( data, type, row ) {
                    if(row.PRO_TITLE[0] == 3) return 'Ampliación';
                        else return data;
                }
            },
            {
            	"title": 'Duración',
                "targets": 9,
                "render": function ( data, type, row ) {
                			if(row.PRO_TITLE[0] == 0 && row.INDEFINIDO) {
								return 'Indefinido, inicio: ' + moment(row.FUNCIONARIOS_DESDE).format("DD/MM/YYYY");
                			}
                            	else return moment(row.FUNCIONARIOS_DESDE).format("DD/MM/YYYY") +' al '+ moment(row.FECHA_TERMINO_LABEL).format("DD/MM/YYYY");
                }
            },
            {
            	"title": 'Etapa',
            	"data": 'TAS_TITLE',
                "targets": 10
            },
            {
                "title": 'Hel++',
                "class": "details-control",
                "targets": 11,
                "render": function ( data, type, row ) {
                	return '<a class="details-control"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                }

            },
            
        ],
		"order": [[ 1, "desc" ]],
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
			"message": '<h2>Licencias Medicas</h2>',
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
	
	function rowChildAdvanceInformation ( d ) {
	    if(d.PRO_TITLE[0] == 3) {
	        d.PREVISION = 'No aplica';
	        d.SALUD = 'No aplica';
	    }
	    return  '<div class="col-sm-6">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información del reemplazo</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul>\
						        		    <li>\
								        	    <b>Cargo: </b>'+ d.CARGO_LABEL +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Motivo: </b>'+ d.MOTIVO_REEMPLAZO_LABEL +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Horas: </b>'+ d.FUNCIONARIOS_HORAS +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Financiamiento: </b>'+ d.FUNCIONARIOS_FINANCIAMIENTO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Prevision: </b>'+ d.PREVISION +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Salud: </b>'+ d.SALUD +'\
		        						    </li>\
		        					    </ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>\
	        	<div class="col-sm-6">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información del Caso</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul>\
						        		    <li>\
								        	    <b>Proceso: </b>'+ d.PRO_TITLE +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Tarea: </b>'+ d.TAS_TITLE +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Usuario actual: </b>'+ d.USR_FIRSTNAME +'\
		        						    </li>\
		        					    </ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>';
	}


    

// Array to track the ids of the details displayed rows
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
	            row.child( rowChildAdvanceInformation( row.data() ) ).show();
	 
	            // Add to the 'open' array
	            if ( idx === -1 ) {
	                detailRows.push( tr.attr('id') );
	            }
	        }
	} );
    
	myTable.on( 'draw', function () {
	        $.each( detailRows, function ( i, id ) {
	            $('#'+id+' td.details-control').trigger( 'click' );
	        } );
	} );
	
	$('#divActivas').click(function(){
		if(estadoBotonActivas){
			resetSearch();
		}	else {
				resetSearch();
				$('#divActivas').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(1).search(filtroActivos, true).draw();
				estadoBotonActivas = true;
			}
	});
	
	$('#divVencen7').click(function(){
		if(estadoBoton7){
			resetSearch();
		}	else{
				resetSearch();
				$('#divVencen7').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(1).search(filtroVencen7, true).draw();
				estadoBoton7 = true;
				
			}
	});
	
	function resetSearch(){
		myTable.columns().search("").draw();
		
		estadoBotonActivas = false;
		$('#divActivas').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton7 = false;
		$('#divVencen7').css("background-color", "rgb(255, 255, 255)");
		
	}
	
});
</script>
