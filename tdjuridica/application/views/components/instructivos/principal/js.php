<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>

<script>
$(document).ready(function() {
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "processing": true,
        "ajax": {
            "url": "<?= site_url('Instructivos/getit') ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "title": 'ID',
                "data": 'id',
                "targets": 0,
                "visible":false
            },
            {
                "title": 'Nombre',
                "data": 'nombre',
                "targets": 1
            },
            {
                "title": 'Tipo',
                "data": 'tipo',
                "targets": 2
            },
            {
                "title": 'Descripción de instructivo',
                "data": 'descripcion',
                "targets": 3,
            },
            {
                "title": 'Link de instructivo',
                "data": null,
                "targets": 4,
                "searchable": false,
                "render": function ( data, type, row ) {
                    return '<a href="<?= site_url('Instructivos/downloadfile/')?>' + row.id +'" type="button" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i> Ir al documento</a>';
                }
            }
        ],
        "order": [[ 2, "asc" ]],
        "language": {
            "url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
        }
    } );
});

</script>