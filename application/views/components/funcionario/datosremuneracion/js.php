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
    var tablaProgramas = $('#tabla-programas').DataTable( {
        "bAutoWidth": false,
        "paging": false,
        "searching": false,
        // "scrollX": true,
		"ajax": {
            "url": "<?= site_url('DatosRemuneracion/getDistribucionProgramas') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'Código',
            	"data": 'CODIGO',
                "targets": 0,
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRE',
                "targets": 1
            },
            {
            	"title": 'Horas',
            	"data": 'HORAS',
                "targets": 2
            },
            {
            	"title": 'Fecha de inicio',
            	"data": 'FECHA_INICIO',
                "targets": 3,
                "render": function(data, type, row){
                	return moment(row.FECHA_INICIO.date).format("DD/MM/YYYY")
                }
            },
            {
            	"title": 'Fecha de término',
                "data": 'FECHA_TERMINO',
                "targets": 4,
                "render": function(data, type, row){
                	return row.FECHA_TERMINO !== null ? moment(row.FECHA_TERMINO.date).format("DD/MM/YYYY") : null;
                }
                
            },
            {
            	"title": 'Centro de costo',
            	"data": 'CENTRO_COSTO',
                "targets": 5
            }
        ],
		"order": [[ 0, "asc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
    var tablaDesempeno = $('#tabla-desempeno').DataTable( {
        "bAutoWidth": false,
        "paging": false,
        "searching": false,
        // "scrollX": true,
		"ajax": {
            "url": "<?= site_url('DatosRemuneracion/getDistribucionDesempeno') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'Centro de Costo',
            	"data": 'CENTRO_COSTO',
                "targets": 0,
            },
            {
            	"title": 'Horas',
            	"data": 'HORAS',
                "targets": 1
            },
            {
            	"title": 'Concepto',
            	"data": 'CONCEPTO',
                "targets": 2
            },
            {
            	"title": 'Fecha de inicio',
            	"data": 'FECHA_INICIO',
                "targets": 3,
                "render": function(data, type, row){
                	return moment(row.FECHA_INICIO.date).format("DD/MM/YYYY")
                }
            },
            {
            	"title": 'Fecha de término',
                "data": 'FECHA_TERMINO',
                "targets": 4,
                "render": function(data, type, row){
                	return row.FECHA_TERMINO !== null ? moment(row.FECHA_TERMINO.date).format("DD/MM/YYYY") : null;
                }
                
            }
        ],
		"order": [[ 0, "asc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});

	// tablaDesempeno.columns.adjust().draw();
	// tablaProgramas.columns.adjust()
	
});



</script>