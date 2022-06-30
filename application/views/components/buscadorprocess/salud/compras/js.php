<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>


<script>

$(document).ready(function() {
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "data": <?= $indicadores[3] ?>,
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
                    if(row.FONDORENDIR_LABEL == 'Si') return '<span class="label label-info">' + data + '</span>';
                    	else return data;
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
            	"data": 'CENTRO',
                "targets": 3,
                "render": function ( data, type, row ) {
                	if(data == 'Administración Central Salud') {
                		if(row.FONDORENDIR_LABEL == 'Si') return 'Central('+ row.DESPACHO_LABEL +')';
                			else return data;
                	} else return data;
                }
            },
            {
            	"title": 'Financiamiento',
            	"data": 'FONDOF_LABEL',
                "targets": 4
            },
            {
            	"title": 'Convenio',
            	"data": 'CONVENIO_LABEL',
                "targets": 5,
            },
            {
            	"title": 'Financiamiento',
            	"data": 'CONVENIO_LABEL',
                "targets": 5,
            },
            {
            	"title": 'Etapa',
            	"data": 'TAS_TITLE',
                "targets": 6,
            },
            {
            	"title": 'Asignado',
            	"data": 'USR_FIRSTNAME',
                "targets": 7,
            },
                        {
                "title": '+',
                "class": "details-control",
                "targets": 8,
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
	
function rowChildAdvanceInformation ( d ) {
	
	if(d.FONDORENDIR_LABEL == 'Si') {
	    return  '<div class="col-sm-6">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Información general</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul>\
						        		    <li>\
								        	    <b>Monto: </b>'+ d.MONTO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>A nombre de: </b>'+ d.BENEFICIARIO +'\
		        						    </li>\
		        						    <li>\
								        	    <b>Para el centro: </b>'+ d.DESPACHO +'\
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
	}	else {
			html = '<div class="col-sm-8">\
		        	<div class="widget-box">\
			        	<div class="widget-header widget-header-flat">\
			        		<h4 class="widget-title">Detalles de compra</h4>\
		        		</div>\
		        		<div class="widget-body">\
			        		<div class="widget-main">\
			        			<div class="row">\
			        				<div class="col-sm-12">\
		        						<ul id="listaDetalles'+ d.APP_NUMBER +'"> ';
							    
								html +=	'</ul>\
		        				    </div>\
		        			    </div>\
		        		    </div>\
	        		    </div>\
	        	    </div>\
	        	</div>\
	        	<div class="col-sm-4">\
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
			return  html;
		}
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
            
            if(row.data().FONDORENDIR_LABEL == 'No'){
	            $.ajax({
		            url: "<?= site_url('Buscadorprocess/getDetalleSaludCompras') ?>/" + row.data().APP_NUMBER,
		            type: "GET",
		            contentType: false,
		            cache: false,
		            processData:false,
		            beforeSend : function(){
		
		            },
		            success: function(response){
		            	console.log(response);
		                var	data = JSON.parse(response);
		                
		                for (i = 0; i < data.length; i++) {
										listadoCompra = '<li>\
													<b>Tipo: </b>'+ data[i]['BIENSERVICIO_LABEL'] +' | <b>Detalle:</b> '+ data[i]['TEXT0000000002'] +' | <b>Cantidad:</b> '+ data[i]['TEXT0000000003']+' | <b>Prespsto:</b> '+ data[i]['TEXT0000000006'] +' | <b>Precio:</b>'+ data[i]['TEXT0000000007'] +' | <b>Para: </b>'+ data[i]['GRIDDESPACHORECIBEINPUTDESPACHO_LABEL'] +'\
								        		</li> ';
								        $('#listaDetalles' + row.data().APP_NUMBER).append(listadoCompra);
									} 
						
		                if(data[0] === 'SUCCESSFUL'){
		
		                }
		                
		                if(data[0] === 'ERROR_NULL_DB'){
		
		                }
		                
		            },
		            error: function(e){
		
		            	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
		                console.log(e);
		                //$("#err").html(e).fadeIn();
		            }
		        });
            }
        }
} );
    
myTable.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
} );
	
	
});
</script>
