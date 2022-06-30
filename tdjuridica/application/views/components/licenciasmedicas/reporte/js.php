<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>


<script>

$(document).ready(function() {
	
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