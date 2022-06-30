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
            "url": "<?= site_url('DatosContractuales/getMovimientosVidaFuncionaria') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'id',
            	"data": 'CodigoVidaFuncionaria',
                "targets": 0,
                "visible": true
            },
            {
            	"title": 'Fecha de inicio',
            	"data": 'FechaInicio',
            	"iDataSort": 9,
                "targets": 1,
                "render": function(data, type, row){
                	return moment(row.FechaInicio).format("DD/MM/YYYY")
                }
            },
            {
            	"title": 'Fecha de término',
                "data": 'FechaTermino',
                "iDataSort": 10,
                "targets": 2,
                "render": function(data, type, row){
                	return row.FechaTermino !== null ? moment(row.FechaTermino).format("DD/MM/YYYY") : null;
                }
            },
            {
            	"title": 'Centro de costo',
            	"data": 'CentroCosto',
                "targets": 3
            },
            {
            	"title": 'Tipo funcionario',
            	"data": 'TipoFuncionario',
                "targets": 4
            },
            {
            	"title": 'Calidad jurídica',
            	"data": 'CalidadJuridica',
                "targets": 5
            },
            {
            	"title": 'Cargo',
            	"data": 'Cargo',
                "targets": 6
            },
            {
            	"title": 'Función',
            	"data": 'Funcion',
                "targets": 7
            },
            {
            	"title": 'Planta',
            	"data": 'Planta',
                "targets": 8
            },
            {
            	"title": 'Filtro inicio',
            	"data": 'FechaInicio',
                "targets": 9,
                "visible": false
            },
            {
            	"title": 'Filtro término',
            	"data": 'FechaTermino',
                "targets": 10,
                "visible": false
            },
        ],
		"order": [[ 0, "asc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});

	function resetSearch(){
		myTable.columns().search("").draw();
	}
	
});


</script>