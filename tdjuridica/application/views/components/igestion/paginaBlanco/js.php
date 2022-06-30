 <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
 <script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
 <script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>
 <script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
 
 <script>
 
 
 
 $(document).ready( function () {

 	var myTable = $('#dynamic-table').DataTable( {
    "bAutoWidth": false,
    "data": <?= $datatable ?>,
	"columnDefs": [
        {
        	"title": 'Rut',
        	"data": 'Rut',
            "targets": 0,
            "visible": true
        },
        {
        	"title": 'Nombres',
        	"data": 'Nombres',
            "targets": 1,
        },
        {
        	"title": 'Paterno',
        	"data": 'ApellidoPaterno',
            "targets": 2,
        },
        {
        	"title": 'Materno',
        	"data": 'ApellidoMaterno',
            "targets": 3,
        },
        {
        	"title": 'Cargo',
        	"data": 'Cargo',
            "targets": 4,
        },
        {
        	"title": 'Categoria',
        	"data": 'Categoria',
            "targets": 5,
        },
        {
        	"title": 'Nivel',
        	"data": 'CodigoNivel',
            "targets": 6,
        },
        {
        	"title": 'Calidad',
        	"data": 'CalidadJuridica',
            "targets": 7,
        },
        {
        	"title": 'Jornada',
        	"data": 'Jornada',
            "targets": 8,
        },
        {
        	"title": 'Inicio',
        	"data": 'FechaInicio',
            "targets": 9,
        },
        {
        	"title": 'Termino',
        	"data": 'FechaTermino',
            "targets": 10,
        },
        {
        	"title": 'Codogo Centro',
        	"data": 'CodigoCentro',
            "targets": 11,
        },
        {
        	"title": 'Centro',
        	"data": 'Centro',
            "targets": 12,
        },
        
    ],
	"order": [[ 0, "desc" ]],
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
	  },
	  {
		"extend": "print",
		"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
		"className": "btn btn-white btn-primary btn-bold",
		"autoPrint": true,
		"message": '<h2>Funcionarios IGestion</h2>',
	  }
	]
} );

var defaultCopyAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
	
	myTable.buttons().container().appendTo( $('.tableTools-container') );
	
    
} );



</script> 
 