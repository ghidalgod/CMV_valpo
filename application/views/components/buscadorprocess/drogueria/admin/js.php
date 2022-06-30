<!-- Autor: Macelo Leiton  -->

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>

<script>

$(document).ready(function() {
    var mesesUsados = <?= $mesesUsados ?>;
    
    var myChart = $('#myChart').css({'width':'100%' , 'height':'250px'});
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	type: 'bar', //line
    borderColor: 'rgba(76, 76, 76, 0.1)',
    data: {
        datasets: 
        [
            { label: 'Enfermeria',  data: mesesUsados[0], backgroundColor: 'rgba(112, 184, 101, 0.9)'}, 
            { label: 'Farmacia', data: mesesUsados[1], backgroundColor: 'rgba(101, 163, 184, 0.9)'},
            { label: 'Maternal', data: mesesUsados[2], backgroundColor: 'rgba(255, 99, 132, 0.9)'},
            { label: 'SAPU',  data: mesesUsados[3], backgroundColor: 'rgba(191, 63, 187, 0.9)'}, 
            { label: 'CEAR', data: mesesUsados[4], backgroundColor: 'rgba(191, 65, 63, 0.9)'},
            { label: 'Cirugia menor', data: mesesUsados[5], backgroundColor: 'rgba(63, 78, 191, 0.9)'},
            { label: 'Cadena de frio',  data: mesesUsados[6], backgroundColor: 'rgba(63, 191, 150, 0.9)'}, 
        ],
        labels: mesesUsados[7], //nombre de meses
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

	var filtroCompletados = "<?php
							if(empty($indicadores[0])) echo "";
								else{
									$filtro = "(";
									foreach($indicadores[0] as $key => $value){
										$filtro .= $value['APP_NUMBER']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";

	var filtroEnCurso = "<?php
							if(empty($indicadores[1])) echo "";
								else{
									$filtro = "(";
									foreach($indicadores[1] as $key => $value){
										$filtro .= $value['APP_NUMBER']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";

	var filtroCancelado = "<?php
							if(empty($indicadores[2])) echo "";
								else{
									$filtro = "(";
									foreach($indicadores[2] as $key => $value){
										$filtro .= $value['APP_NUMBER']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	
	var estadoBtnCompletado = false;
	var estadoBtnEnCurso = false;
	var estadoBtnCancelado = false;
	
	
    var myTable =$('#dynamic-table').DataTable( {
          "bAutoWidth": false,
          "order":[],
            'ajax':{
                "url": "<?= site_url('Buscadorprocess/getDrogueriaTables') ?>",
                "type": "GET"
            },
            
            'columns':[
                { "title": 'Caso', "data": 'APP_NUMBER',"targets": 0},
                
                { "title": 'Estado', "data": 'APP_STATUS', "targets": 1, 
                "render": function ( data, type, row ) {
                	if(data == 'TO_DO')  return '<span class="label label-warning" >'+ 'En curso' +'</span>' ;
                	else if(data == 'COMPLETED') return '<span class="label label-success" >'+ 'Completado' +'</span>' ;
                	else if(data == 'CANCELLED') return '<span class="label label-danger" >'+ 'Cancelado' +'</span>' ;
                	return data; } },
                { "title": 'Categoria', "data": 'CATEGORIAPEDIDO_LABEL', "targets": 2,
                	"render": function ( data, type, row ) {
                	if(row.TIPOPEDIDO_LABEL == 'Cadena Frío')  return 'Cadena Frío' ;
                	else if(row.TIPOPEDIDO_LABEL == 'Mensual' && (row.TAS_TITLE == 'Bodega dental' || row.TAS_TITLE == 'Listo para despacho dental')) return 'Dental' ;
                	else if(row.TIPOPEDIDO_LABEL == 'Mensual' && (row.TAS_TITLE == 'Bodega Insumos' || row.TAS_TITLE == 'Listo para despacho Insumos')) return 'Enfermeria' ;
                	else if(row.TIPOPEDIDO_LABEL == 'Mensual' && (row.TAS_TITLE == 'Bodega farmacia' || row.TAS_TITLE == 'Listo para despacho farmacia')) return 'Farmacia' ;
                	else if(row.TIPOPEDIDO_LABEL == 'Mensual') return 'Mensual' ;
                	return data; }
                },
                { "title": 'Centro', "data": 'CENTROSOLICITANTE_LABEL', "targets": 3},
                { "title": 'solicitante',  "data": 'NOMBRESOLICITANTE', "targets": 4},
                { "title": 'Tipo',  "data": 'TIPOPEDIDO_LABEL', "targets": 5},
              
                	
                { "title": 'Inicio Solicitud',  "data": 'APP_CREATE_DATE', "targets": 6,"render": function ( data, type, row ) {
                	if(!isNaN(data)) return 'No inicia';
                	else if(data == data) { return moment(row.APP_CREATE_DATE).format("DD/MM/YYYY HH:mm:ss");}
                	return data; }},
                	
                  { "title": 'Delegacion',"data": 'DEL_DELEGATE_DATE',"targets": 7, "render": function ( data, type, row ) {
                	if(data == data) { return moment(row.DEL_DELEGATE_DATE).format("DD/MM/YYYY HH:mm:ss");}
                	return data; }},
                	
                { "title": 'Termino', "data": 'DEL_FINISH_DATE', "targets": 8,"render": function ( data, type, row ) {
                    if(!isNaN(data)) return '<span class="label label-alert" >'+ 'En proceso...' +'</span>' ;
                	if(data == data) { return moment(row.DEL_FINISH_DATE).format("DD/MM/YYYY HH:mm:ss");}
                	return data; }
                   	},
                { "title": 'Tarea',  "data": 'TAS_TITLE', "targets": 9},
                { "title": 'User Name',  "data": 'USR_FIRSTNAME', "targets": 10,"visible": false},
                { "title": 'User LastName',  "data": 'USR_LASTNAME', "targets": 11,"visible": false},
                 {
            	"title": 'Nombre Usuario',
            	"data": null,
                "targets": 12,
                "render": function ( data, type, row ) {
                    return row.USR_FIRSTNAME + ' '+ row.USR_LASTNAME;
                }
            },
                { "title": 'VIEW_APP_UID', "data": 'VIEW_APP_UID',"targets": 13,"visible": false}
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
    	
	
	$('#divCompletados').click(function(){
		if(estadoBtnCompletado){
			resetSearch();
		}	else {
				resetSearch();
				$('#divCompletados').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroCompletados, true).draw();
				estadoBtnCompletado = true;
			}
	});
	
	$('#divEnCurso').click(function(){
		if(estadoBtnEnCurso){
			resetSearch();
		}	else {
				resetSearch();
				$('#divEnCurso').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroEnCurso, true).draw();
				estadoBtnEnCurso = true;
			}
	});
	
	$('#divCancelado').click(function(){
		if(estadoBtnCancelado){
			resetSearch();
		}	else {
				resetSearch();
				$('#divCancelado').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroCancelado, true).draw();
				estadoBtnCancelado = true;
			}
	});
	
	function resetSearch(){
	myTable.columns().search("").draw();
		
	estadoBtnCompletado = false;
	$('#divCompletados').css("background-color", "rgb(255, 255, 255)");
	
	estadoBtnEnCurso = false;
	$('#divEnCurso').css("background-color", "rgb(255, 255, 255)");
	
	estadoBtnCancelado = false;
	$('#divCancelado').css("background-color", "rgb(255, 255, 255)");
	}
	
	new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al portapapeles</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"exportOptions": {
				//"columns": ':not(:first):not(:last)'
				"columns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,12]
			}
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"autoPrint": true,
			"message": '<h2>Pedidos Droguería</h2>',
			"exportOptions": {
				 //"columns": ':visible:not(:last-child)'
				 "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,12]
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
	
});
</script>
<script type="text/javascript">
</script>