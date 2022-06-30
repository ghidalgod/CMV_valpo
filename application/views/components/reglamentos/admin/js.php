<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>

<script>
$(document).ready(function() {
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= site_url('Reglamentos/getit') ?>",
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
                "title": 'Descripción del archivo',
                "data": 'descripcion',
                "targets": 3,
            },
            {
                "title": 'Link de descarga',
                "data": null,
                "targets": 4,
                "searchable": false,
                "render": function ( data, type, row ) {
                    var link_edit = '<?= site_url('reglamentos/downloadfile')?>/' + row.id; 
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var ir_normal = '<a href="' + link_edit + '"  type="button" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i> Ir al documento</a>';
                    var remove_normal = '<a class="btn btn-danger btn-sm" title="Eliminar" href="#" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '" data-nombre="' + row.nombre + '"><i class="ace-icon fa fa-trash-o"" aria-hidden="true"></i> Eliminar</a>';
                    
                    options_normal += ir_normal + remove_normal;
                    options_normal += '</div>';
                    
                    return options_normal;
                }
            }
        ],
        "order": [[ 2, "asc" ]],
        "language": {
            "url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
        }
    } );
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        
        var id = button.data('id'); 
        var nombre = button.data('nombre');       
        var modal = $(this);    
        
        modal.find('.delete-modal-codigo').text(nombre);
        modal.find('#deleteButton').attr('onclick', "btnRemove(" + id + ")");
    });
    
    $('.loading-delete-btn').on(ace.click_event, function () {
        var btn = $(this);
        btn.button('loading');
    });
});

function btnRemove(id) {
    $.ajax({
        url: "<?= site_url('Reglamentos/deleteold') ?>/" + id,
        type: 'POST',                
        dataType: 'json',
        success:function(response) {
            if(response.type === 'Error') {
                $.gritter.add({
                    title: 'Error eliminaci¨®n',
                    text: 'No se ha podido eliminar el archivo.',
                    class_name: 'gritter-error'
                });
            }
		$('#deleteModal').modal('hide');
            setTimeout(function () {
                $('.loading-delete-btn').button('reset')
            }, 500);
            
            $('#dynamic-table').DataTable().ajax.reload(null, false);
        }
    });
}
</script>