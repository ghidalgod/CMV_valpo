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
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
		"ajax": {
            "url": "<?= site_url('Permisos/getPermisos') ?>",
            "type": "GET"
        },
		"columnDefs": [
			{
	            "title": 'ID',
            	"data": 'CodigoPermiso',
                "targets": 0,
                "visible": true
			
			},
            {
            	"title": 'N° de resolución',
            	"data": 'NumResolucion',
                "targets": 1,
                "visible": true
            },
            {
            	"title": 'Fecha de inicio',
            	"data": 'FechaInicio',
            	"iDataSort": 8,
                "targets": 2,
                "render": function(data, type, row){
                	return moment(row.FechaInicio).format("DD/MM/YYYY")
                }
            },
            {
            	"title": 'Fecha de término',
                "data": 'FechaTermino',
                "iDataSort": 9,
                "targets": 3,
                "render": function(data, type, row){
                	return row.FechaTermino !== null ? moment(row.FechaTermino).format("DD/MM/YYYY") : null;
                }
                
            },
            {
            	"title": 'Días',
            	"data": 'CantidadPermiso',
                "targets": 4
            },
            {
            	"title": 'Días/Jornada',
            	"data": 'DiaHora',
                "targets": 5
            },
            {
            	"title": 'Tipo permiso',
            	"data": 'TipoPermiso',
                "targets": 6
            },
            {
            	"title": 'Motivo',
            	"data": 'Causa',
                "targets": 7
            },
            {
            	"title": 'Filtro inicio',
            	"data": 'FechaInicio',
                "targets": 8,
                "visible": false
            },
            {
            	"title": 'Filtro término',
            	"data": 'FechaTermino',
                "targets": 9,
                "visible": false
            },
        ],
        order: [0, "asc"],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});

	function resetSearch(){
		myTable.columns().search("").draw();
	}
	
});


</script>