<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>


<script>
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
						
	console.log(filtroVencen7);
						
	var estadoBotonActivas = false;
	var estadoBoton7 = false;
	
$(document).ready(function() {
    
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
            	"title": 'Caso',
            	"data": 'APP_NUMBER',
                "targets": 1,
                "render": function ( data, type, row ) {
                    if(row.PRO_TITLE[0] == 1) return '<span class="label label-info">' + data + '</span>';
                    if(row.PRO_TITLE[0] == 2) return '<span class="label label-success">' + data + '</span>';
                    if(row.PRO_TITLE[0] == 3) return '<span class="label label-yellow">' + data + '</span>';
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
            	"data": 'CENTRO_COSTO',
                "targets": 3,
            },
            {
            	"title": 'RUN Reemplazante',
            	"data": 'RUT_REEMPLAZANTE',
                "targets": 4
            },
            {
            	"title": 'Nombre Reemplazante',
            	"data": null,
                "targets": 5,
                "render": function ( data, type, row ) {
                	return row.NOMBRE_REEMPLAZANTE + ' '+ row.APELLIDO_REEMPLAZANTE;
                }
            },
            {
            	"title": 'Motivo',
            	"data": 'MOTIVO_REEMPLAZO',
                "targets": 6,
            },
            {
            	"title": 'Hrs',
            	"data": 'HORAS',
            	"searchable": false,
	            "orderable": false,
                "targets": 7,
            },
            {
            	"title": 'Duración',
                "targets": 8,
                "searchable": false,
	            "orderable": false,
                "render": function ( data, type, row ) {
                            return moment(row.FECHA_INICIO).format("DD/MM/YYYY") +' al '+ moment(row.FECHA_TERMINO).format("DD/MM/YYYY");
                }
            },
            {
            	"title": 'Inicio',
                "targets": 9,
                "iDataSort": 15,
                "render": function ( data, type, row ) {
                            return moment(row.FECHA_INICIO).format("DD/MM/YYYY");
                }
            },
            {
            	"title": 'Termino',
                "targets": 10,
                "iDataSort": 16,
                "render": function ( data, type, row ) {
                            return moment(row.FECHA_TERMINO).format("DD/MM/YYYY");
                }
            },
            {
            	"title": 'Nombre Reemplazado',
            	"data": null,
                "targets": 11,
                "render": function ( data, type, row ) {
                    return row.NOMBRE_FUNCIONARIO + ' '+ row.APELLIDO_FUNCIONARIO;
                }
            },
            {
            	"title": 'RUN Reemplazado',
            	"data": 'RUT_FUNCIONARIO',
                "targets": 12
            },
            {
            	"title": 'Etapa',
            	"data": 'TAS_TITLE',
                "targets": 13
            },
            {
                "title": '+',
                "class":          "details-control",
                "searchable": false,
	            "orderable": false,
                "targets": 14,
                "render": function ( data, type, row ) {
                	return '<a class="details-control"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                }

            },
            {
            	"title": 'FILTER_DATE_INICIO',
            	"data": 'FECHA_INICIO',
                "targets": 15,
                "visible": false
            },
            {
            	"title": 'FILTER_DATE_TERMINO',
            	"data": 'FECHA_TERMINO',
                "targets": 16,
                "visible": false
            },
            {
            	"title": 'Cargo',
            	"data": 'CARGO',
                "targets": 17,
                "visible": false
            },
            {
            	"title": 'Nombres reemplazado',
            	"data": 'NOMBRE_FUNCIONARIO',
                "targets": 18,
                "visible": false
            },
            {
            	"title": 'Apellido reemplazado',
            	"data": 'APELLIDO_FUNCIONARIO',
                "targets": 19,
                "visible": false
            },
        ],
		"order": [[ 1, "desc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
	
	
	new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "colvis",
			"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Mostrar/Ocultar columnas</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"columns": [3,8,9,10]
		  },
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al portapapeles</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"exportOptions": {
				"columns": [1,2,3,4,5,6,7,8,9,10,17,18,19,12,13],
			}
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"autoPrint": true,
			"message": '<h2>Casos process salud</h2>',
			"exportOptions": {
				"columns": [1,2,3,4,5,6,7,8,9,10,17,18,19,12,13]
			}
		  }
		]
	} );
	
	myTable.buttons().container().appendTo( $('.tableTools-container') );
	
	//Mensaje azul cuando se termina de copiar las columnas
	var defaultCopyAction = myTable.button(1).action();
	myTable.button(1).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
	
	var defaultColvisAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		
		defaultColvisAction(e, dt, button, config);
		
		if($('.dt-button-collection > .dropdown-menu').length == 0) {
			$('.dt-button-collection')
			.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
			.find('a').attr('href', '#').wrap("<li />")
		}
		$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
	});
	
	setTimeout(function() {
		$($('.tableTools-container')).find('a.dt-button').each(function() {
			var div = $(this).find(' > div').first();
			if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
			else $(this).tooltip({container: 'body', title: $(this).text()});
		});
	}, 500);
	
	function rowChildAdvanceInformation ( d ) {
	    if(d.FECHA_PAGO == null) d.FECHA_PAGO = 'No ingresado';
	        else d.FECHA_PAGO = moment(d.FECHA_PAGO).format("DD/MM/YYYY");
	    if(d.PRO_TITLE[0] == 3) d.TELEFONO_REEMPLAZANTE = 'No aplica';
	    vista = '<div class="col-sm-6">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información del reemplazante</h4>\
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
								        	    <b>Motivo: </b>'+ d.MOTIVO_REEMPLAZO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Distribución Horas: </b>'+ d.DISTRIBUCION_HORARIO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Fecha de pago: </b>'+ d.FECHA_PAGO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Telefono: </b>'+ d.TELEFONO_REEMPLAZANTE +'\
		        						    </li>';
		        						    
		        						    
		if(d.PRO_TITLE[0] == 1)  {
			vista +=						'<li>\
								        	    <b>Dirrección: </b>'+ d.DIRECCION_REEMPLAZANTE +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Nacimiento </b>'+ moment(d.FECHA_NAC_REEMPLAZANTE).format("DD/MM/YYYY") +'\
		        						    </li>';
			
		}      						    
		        						    
		vista +=  					    '</ul>\
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
								        	    <b>Usuario actual: </b>'+ d.USR_FIRSTNAME +' '+ d.USR_LASTNAME +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Solicitante: </b>'+ d.NOMBRE_SOLICITANTE +'\
		        						    </li>\
		        					    </ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>';
	        	
	    return  vista;
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
