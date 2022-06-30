<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>

<script>

$(document).ready(function() {
	var numeroTrabajando = 0;
	var numeroDescansando = 0;
	var numeroTrabajando = 0;
	var numeroAcumulado = 0;
	var numeroInactivo = 0;

	var myTable =	$('#dynamic-table').DataTable( {
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
													return '<span class="label label-danger" >'+ texto +'</span>';
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
				                "title": '+',
				                "class": "details-control",
				                "orderable": false,
				                "targets": 11,
				                "render": function ( data, type, row ) {
				                	return '<a class="details-control"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
				                }
				
				            },
				            {
				            	"title": 'Admin',
				                "targets": 12,
				                "orderable": false,
				                "render": function ( data, type, row ) {
				                	return '<a class="blue" title="Editar" href="<?= site_url('DiasLibres/editPersonal')?>/'+ row.RUT +'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>\
				                			<a href="#modalEliminarPersonal"  data-toggle="modal" class="red"  title="Eliminar" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\
				                			<div class="modal fade" id="modalEliminarPersonal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				                				<div class="modal-dialog" role="document">\
				                					<div class="modal-content">\
				                						<div class="modal-header">\
				                							<h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>\
				                							<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
				                								<span aria-hidden="true">&times;</span>\
				                							</button>\
				                						</div>\
				                						<div class="modal-body">\
				                							No se puede eliminar personal via TD, contactese con el soporte.\
				                						</div>\
				                						<div class="modal-footer">\
				                							<button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>\
	    												</div>\
	    											</div>\
												</div>\
											</div>'
				                	
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
						"order": [[ 0, "desc" ]],
						language: {
				        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
				    	}
					});
	
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
			        		else $(row).addClass('blue');
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
			            {
				                "title": '+',
				                "orderable": false,
				                "targets": 6,
				                "render": function ( data, type, row ) {
				                	if(row.PERMISO == 'Día Administrativo'){
				                		linkEdit   = "<?= site_url('DiasLibres/editDA')?>/" + row.ID;
				                		linkDelete = "<?= site_url('DiasLibres/deleteDA')?>/"+row.ID;
				                		permiso    = "DiaAdm";
				                		console.log(linkDelete);
				                		return '<a class="blue" title="Editar" href="'+linkEdit+'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>\
											<a href="#modalEliminar'+permiso.concat('',row.ID)+'"  data-toggle="modal" class="red"  title="Eliminar'+permiso+'" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\
				                			<div class="modal fade" name="modelEliminar'+permiso+'" id="modalEliminar'+permiso.concat('',row.ID)+'" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				                				<div class="modal-dialog" role="document">\
				                					<div class="modal-content">\
				                						<div class="modal-header">\
				                							<h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>\
				                							<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
				                								<span aria-hidden="true">&times;</span>\
				                							</button>\
				                						</div>\
				                						<div class="modal-body">\
				                							Esta seguro que desea eliminar este '+row.PERMISO+'?\
				                						</div>\
				                						<div class="modal-footer">\
				                							<button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>\
	        												<a href="'+linkDelete+'" class="btn btn-info" role="button">Eliminar</a>\
	    												</div>\
	    											</div>\
												</div>\
											</div>';
				                	}else {
				                			linkEdit   = "<?= site_url('DiasLibres/editFL')?>/" + row.ID;
				                			linkDelete = "<?= site_url('DiasLibres/deleteFL')?>/"+row.ID;
				                			permiso    = "FL"
				                			return '<a class="blue" title="Editar" href="'+linkEdit+'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>\
				                			<a href="#modalEliminar'+permiso.concat('',row.ID)+'"  data-toggle="modal" class="red"  title="Eliminar'+permiso+'" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\
				                			<div class="modal fade" name="modelEliminar'+permiso+'" id="modalEliminar'+permiso.concat('',row.ID)+'" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				                				<div class="modal-dialog" role="document">\
				                					<div class="modal-content">\
				                						<div class="modal-header">\
				                							<h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>\
				                							<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
				                								<span aria-hidden="true">&times;</span>\
				                							</button>\
				                						</div>\
				                						<div class="modal-body">\
				                							Esta seguro que desea eliminar este Feriado Legal?\
				                						</div>\
				                						<div class="modal-footer">\
				                							<button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>\
	        												<a href="'+linkDelete+'" class="btn btn-info" role="button">Eliminar</a>\
	    												</div>\
	    											</div>\
												</div>\
											</div>';
				                	}
			  	                					                
				                	
				                }
				
				            },
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
		return  '<div class="row">\
				    <table id="dynamic-table2'+ d.ID +'" class="table table-striped table-bordered table-hover compact"></table>\
				</div>';
				
	   
	}
			
});
	function relocate_home()
	{
	     location.href = "http://tdcmvalparaiso.cl/codiad/workspace/desarrollo/index.php/DiasLibres/addPersonal";
	} 		
	
 </script>