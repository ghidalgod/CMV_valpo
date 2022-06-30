<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>


<script>
function miajax(licenciaId){//event.preventDefault();
	$.ajax({
    url: '<?php echo base_url("index.php/LicenciasMedicas/setDatosPersonal/"); ?>'+licenciaId,
    type: $('#personal'+licenciaId).attr("method"),
    data: $('#personal'+licenciaId).serialize(),
    
    success: function(respuesta) {
    	var response = JSON.parse(respuesta);
    	
    	$.each(response, function(i, response) {
			if(response == 'DAY_NULL'){
				$.gritter.add({
	                title: 'La cantidad de días no puede quedar vacío, ni ser 0, debe ingresar un monto válido',
	                class_name: 'gritter-error'
	            });
			}
			if(response == 'SUCCESS'){
				$.gritter.add({
	                title: 'Se ha agregado satisfactoriamente lo datos de pago',
	                class_name: 'gritter-success'
	            });
	            $('#dynamic-table').DataTable().ajax.reload(); // RECARGA LA DATATABLE
			}
			if(response == 'MNT_NULL'){
				$.gritter.add({
	                title: 'El monto no puede quedar vacío, debe ingresar un valor',
	                class_name: 'gritter-error'
	            });
			}
			
		});
    },
    error: function() {
    	console.log('ERROR');
    	alert('Error!');
        }
      });
    }

function getDatosPersonal(licenciaId){
		$.ajax({
    	url: '<?php echo base_url("index.php/LicenciasMedicas/getDatosPersonal/"); ?>'+licenciaId,
        type: "GET",
	    success: function(respuesta) {
            
            var datos = JSON.parse(respuesta)[0];
            
            document.getElementById("estado_pago"+licenciaId).options.item(datos.estado_pago).selected = 'selected';
            document.getElementById("monto"+licenciaId).setAttribute("value",datos.monto);
			
			document.getElementById("resolucion"+licenciaId).options.item(datos.resolucion).selected = 'selected';
            
            document.getElementById("cant_dias"+licenciaId).setAttribute("value",datos.cantidad_dias);
            
            document.getElementById("dias_pagados"+licenciaId).setAttribute("value",datos.dias_pagados);
            
            
            if(datos.resolucion == 2 || datos.resolucion == 3){
            	document.getElementById("div_cant_dias"+licenciaId).setAttribute("style","display:inline");
        		document.getElementById("div_cant_dias1"+licenciaId).setAttribute("style","display:inline");
            }

	    },
	    error: function() {
	    	console.log('ERROR');
	    	alert('Error!');
	        }
	      });	
		
	}

function checkIfOther(licenciaId){
	var combo = document.getElementById("resolucion"+licenciaId);
	
	var selected = combo.options[combo.selectedIndex].text;
	
    if(selected == '3. Ampliada' || selected == '4. Reducida'){           

        document.getElementById("div_cant_dias"+licenciaId).setAttribute("style","display:inline");
        document.getElementById("div_cant_dias1"+licenciaId).setAttribute("style","display:inline");

    }
    else{

        document.getElementById("div_cant_dias"+licenciaId).setAttribute("style","display:none");
        document.getElementById("div_cant_dias1"+licenciaId).setAttribute("style","display:none");
    }

}






$(document).ready(function() {
	
	var estados_pagos = JSON.parse(<?php
			echo json_encode($estadosPagos);
		?>);
	
	var resoluciones = JSON.parse(<?php
			echo json_encode($resolucion);
		?>);
		

						
	var filtroActivos = "<?php
							if(empty($reporte['activas'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['activas'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroVencen7 = "<?php
							if(empty($reporte['vencen7dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['vencen7dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroUltimos30 = "<?php
							if(empty($reporte['ultimo30dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['ultimo30dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroUltimos365 = "<?php
							if(empty($reporte['ultimo30dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['ultimo365dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	
	var estadoBotonActivas = false;
	var estadoBoton7 = false;
	var estadoBoton30 = false;
	var estadoBoton365 = false;
    

    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
		"ajax": {
            "url": "<?= site_url('LicenciasMedicas/getLicenciasMedicas') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'id',
            	"data": 'ID',
                "targets": 0,
                "visible": false
            },
            {
            	"title": 'Ingresado',
            	"data": 'FECHA_REGISTRO',
                "targets": 1,
                "iDataSort": 13,
                "render": function(data, type, row){
                	if(row.CORREO == 1) return '<span class="label label-success">' + moment(row.FECHA_REGISTRO).format("DD/MM/YY") + '</span>';
                    if(row.CORREO == 0) return '<span class="label label-yellow">' + moment(row.FECHA_REGISTRO).format("DD/MM/YY") + '</span>';
                }
            },
            {
            	"title": 'RUN',
                "targets": 2,
                "render": function ( data, type, row ) {
                	num = row.RUT;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
                	return num +'-'+ row.DIGITO;
                }
                
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRE',
                "targets": 3,
                "render": function ( data, type, row ) {
                	return row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO;
                }
                
            },
            {
            	"title": 'N°Lic',
            	"data": 'NLIC',
                "targets": 4,
                "render": function(data, type, row){
                	if(row.NLIC.charAt(row.NLIC.length - 2) === '-') return '<span class="label arrowed">' + row.NLIC + '</span>';
	                    else return '<span class="label label-info">' + row.NLIC + '</span>';
                }
            },
            {
            	"title": 'Período',
            	"data": 'PERIODO',
                "targets": 5,
                "render": function(data, type, row){
                	return moment(row.PERIODO).format("DD/MM/YY");
                }
            },
            {
            	"title": 'Días',
            	"data": 'DIAS',
                "targets": 6,
            },
            {
            	"title": 'Cargo',
            	"data": 'CARGO',
                "targets": 7,
            },
            {
            	"title": 'ESTAB',
            	"data": 'ESTAB',
                "targets": 8,
            },
            {
            	"title": 'CONV',
            	"data": 'CONV',
                "targets": 9,
            },
            {
            	"title": 'Tipo',
            	"data": 'TIPO',
                "targets": 10
            },
            {
            	"title": 'Reposo',
            	"data": 'REPOSO',
            	"orderable": false,
                "targets": 11
            },
            {
            	"title": 'Salud',
            	"data": 'SALUD',
                "targets": 12
            },
            {
            	"title": 'FILTER_DATE',
            	"data": 'FECHA_REGISTRO',
                "targets": 13,
                "visible": false
            },
            {
            	"title": 'Resolucion',
            	"data": 'RESOLUCION',
                "targets": 14,
                "render": function(data,type,row){
                	var nombre = 'No existe Información del Pago';
                	$.each(resoluciones, function(i, estado) {
						if(estado.id == row.RESOLUCION){
							nombre = estado.nombre;
						}
						
					});
                	
                	return data;
                }
            },
            {
            	"title": 'ESTADO_PAGO',
            	"data": 'ESTADO_PAGO',
                "targets": 15,
                "visible": false
            },
            {
            	"title": 'MONTO',
            	"data": 'MONTO',
                "targets": 16,
                "visible": false
            },
            {
            	"title": 'RESOLUCION',
            	"data": 'RESOLUCION',
                "targets": 17,
                "visible": false
            },
            {
            	"title": 'CANTIDAD_DIAS',
            	"data": 'CANTIDAD_DIAS',
                "targets": 18,
                "visible": false
            },
            {
            	"title": 'Nombre Médico',
            	"data": 'MEDICO',
                "targets": 19,
            },
            {
            	"title": 'Run Médico',
                "targets": 20,
                "render": function ( data, type, row ) {
                	num = row.RUT_MEDICO;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
                	return num +'-'+ row.DIGITO_RUT_MEDICO;
                }
            },
            {
                "title": 'Info Pago',
                "class": "details-control",
                "targets": 21,
                "render": function ( data, type, row ) {
                	return '<a class="details-control" ><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                }

            },
            
        ],
		"order": [[ 1, "desc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	function rowChildAdvanceInformation ( d ) {
		var emptyOption = '<option selected>Selecciona una opción </option>'
		var estados = '<select name="estado_pago'+d.ID+'" id="estado_pago'+d.ID+'" class="form-control" style="width: 100%;">'+emptyOption;
		$.each(estados_pagos, function(i, estado) {
			
				estados+='<option value="'+estado.id+'" >'+estado.nombre+'</option>';
			}
		);
		estados+='</select>'
		
		var resolucion = '<select name="resolucion'+d.ID+'" id="resolucion'+d.ID+'" class="form-control" onchange=checkIfOther('+d.ID+'); style="width: 100%;">'+emptyOption;
		
		$.each(resoluciones, function(i, res) {
		
				resolucion+='<option value="'+res.id+'" >'+res.nombre+'</option>';

			}
		);
		resolucion+='</select>'
		
		
		var status = 'style="visibility: hidden"';
		
	    return  '<form id="personal'+d.ID+'" name="personal" role="form"\
		    		method="post">\
		    		<div class="col-sm-12">\
			        	<div class="widget-box">\
				        	<div class="widget-header widget-header-flat">\
				        		<h4 class="widget-title">Información de Pago</h4>\
			        		</div>\
			        		<div class="widget-body">\
			        		<fieldset>\
				        		<div class=row>\
					        		<div class=row>\
				    			    	</div>\
				    			    	\
				    			    <div class=row>\
					    			   	<div class="col-sm-2">\
		        							<b>Estado Pago</b>\
		        						</div>\
		        						<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-3">\
		        							'+estados+'\
		        						</div>\
				    			    </div>\
				    			    \
				    			    <div class=row>\
					    			   	<div class="col-sm-2">\
		        							<b>Días pagados(Pendiente de pago)</b>\
		        						</div>\
		        						<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-3">\
		        							<input id="dias_pagados'+d.ID+'" name="dias_pagados'+d.ID+'" value="" class="form-control" style="width: 100%;" type="number" min="0">\
		        						</div>\
				    			    </div>\
				    			    \
				    			    <div class=row>\
					    			   	<div class="col-sm-2">\
		        							<b>Monto</b>\
		        						</div>\
		        						<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-3">\
		        							<input id="monto'+d.ID+'" name="monto'+d.ID+'" value="" class="form-control" style="width: 100%;" type="number" min="0" step="10000">\
		        						</div>\
		        						<div id = "div_cant_dias1'+d.ID+'" class="col-sm-2" '+status+'>\
		        							<br>\
		        							<b>Cantidad días</b>\
		        						</div>\
				    			    </div>\
				    			    <div class=row>\
					    			   	<div class="col-sm-2">\
		        							<b>Resolución</b>\
		        						</div>\
		        						<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-3">\
		        							'+resolucion+'\
		        						</div>\
		        						<div id="div_cant_dias'+d.ID+'" class="col-sm-1" '+status+'>\
		        							<input id="cant_dias'+d.ID+'" name="cant_dias'+d.ID+'" value="" class="form-control" style="width: 100%;" type="number" min="0" step="1">\
		        						</div>\
				    			    </div>\
				    			    <div class=row>\
					    			   	<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-2">\
		        							\
		        						</div>\
		        						<div class="col-sm-3">\
		        							<input id="enviar" name="enviar" type="button" class="btn btn-success" onclick="miajax('+d.ID+');" value="Guardar">\
		        						</div>\
				    			    </div>\
				    			    <div class=row>\
				    			    </div>\
				    			    </div>	\
			    			    </div>\
		    			    </fieldset>\
	        		    </div>\
	    		    </div>\
	       		</form>';
	}

	
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
	            getDatosPersonal(row.data().ID);
	            //console.log(row.data().ID);
	 
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
	
	

	
	new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al portapapeles</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"exportOptions": {
				"columns": [1,2,3,4,5,6,7,8,9,10,11,12,15,16,17,18]
			}
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"autoPrint": true,
			"message": '<h2>Licencias Medicas</h2>',
			"exportOptions": {
				"columns": [1,2,3,4,5,6,7,8,9,10,11,12,15,16,17,18]
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
	
	$('#divActivas').click(function(){
		if(estadoBotonActivas){
			resetSearch();
		}	else {
				resetSearch();
				$('#divActivas').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroActivos, true).draw();
				estadoBotonActivas = true;
			}
	});
	
	$('#divVencen7').click(function(){
		if(estadoBoton7){
			resetSearch();
		}	else{
				resetSearch();
				$('#divVencen7').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroVencen7, true).draw();
				estadoBoton7 = true;
				
			}
	});
	
	$('#divUltimos30').click(function(){
		if(estadoBoton30){
			resetSearch();
		}	else{
				resetSearch();
				$('#divUltimos30').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroUltimos30, true).draw();
				estadoBoton30 = true;
				
			}
	});
	
	$('#divUltimos365').click(function(){
		if(estadoBoton365){
			resetSearch();
		}	else{
				resetSearch();
				$('#divUltimos365').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroUltimos365, true).draw();
				estadoBoton365 = true;
				
			}
	});
	
	function resetSearch(){
		myTable.columns().search("").draw();
		
		estadoBotonActivas = false;
		$('#divActivas').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton7 = false;
		$('#divVencen7').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton30 = false;
		$('#divUltimos30').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton365 = false;
		$('#divUltimos365').css("background-color", "rgb(255, 255, 255)");
	}
	
});

</script>