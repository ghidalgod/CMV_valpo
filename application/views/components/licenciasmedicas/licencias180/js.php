<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>

<script>
$(document).ready(function() {
    var myTable = $('#dynamic-table').DataTable({
        "bAutoWidth": false,
		"ajax": {
            "url": "<?= site_url('LicenciasMedicas/getPersonasSaludIncompatible') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'RUT',
                "targets": 0,
                "render": function ( data, type, row ) {
                	num = row.RUT;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
                	return num +'-'+ row.DIGITO;
                }
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRES',
                "targets": 1,
                "render": function ( data, type, row ) {
                	return row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO;
                }
            },
            {
            	"title": 'Centro',
            	"data": 'ESTAB',
                "targets": 2,
            },
            {
            	"title": 'Cargo',
            	"data": 'CARGO',
                "targets": 3,
            },            
            {
            	"title": 'Días',
            	"data": 'DIAS',
                "targets": 4,
            },
            {
                "title": 'Detalle',
                "class": "details-control",
                "orderable": false,
                "targets": 5,
                "render": function ( data, type, row ) {
                	return '<a class="details-control"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                }

            },
        ],
		"order": [[ 4, "desc" ]],
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

	            var myTable2 = $('#dynamic-table2' + row.data().RUT).DataTable( {
			        "bAutoWidth": false,
			        "paging": false,
			        "searching": false,
			        "ajax": {
			            "url": "<?= site_url('LicenciasMedicas/getDetalleSaludIncompatible/') ?>" + row.data().RUT,
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
			            	"title": 'Número de licencia',
			            	"data": 'NLIC',
			                "targets": 1
			            },
			            {
			            	"title": 'Tipo',
			            	"data": 'TIPO',
			                "targets": 2
			            },			            
			            {
			            	"title": 'Inicio',
			            	"data": 'PERIODO',
			            	"iDataSort": 6,
			                "targets": 3,
			                "render": function(data, type, row){
			                	return moment(row.PERIODO).format("DD/MM/YYYY");
			                }
			            },
			            {
				            "title": 'Días',
			            	"data": 'DIAS',
			                "targets": 4
			            },
			            {
				            "title": 'Término',
			            	"data": 'TERMINO',
			            	"iDataSort": 7,
			                "targets": 5,
			                "render": function(data, type, row){
			                	return moment(row.TERMINO).format("DD/MM/YYYY");
			                }			                
			            },
			            {
			            	"title": 'Filtro inicio',
			            	"data": 'PERIODO',
			                "targets": 6,
			                "visible": false
			            },
			            {
			            	"title": 'Filtro término',
			            	"data": 'TERMINO',
			                "targets": 7,
			                "visible": false
			            },				            
			        ],
					"order": [[ 3, "desc" ]],
					language: {
			        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
			    	}
				});
				
	        }
	        
	} );
	
	function rowChildAdvanceInformation ( d, indexRow ) {
	    return `<div class="widget-header widget-header-flat">\
	        		<h4 class="widget-title">Detalle de licencias</h4>\
        		</div>\
        		<div class="widget-body">\
	        		<div class="widget-main">\
	        			<div class="row">\
	        				<div class="col-sm-12">\
					    		<div class="row">\
								    <table id="dynamic-table2${d.RUT}" class="table table-bordered table-hover"></table>\
								</div>
        				    </div>\
        			    </div>\
        		    </div>\
    		    </div>`;
	}	
	
});

</script>