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
    //initiate dataTables plugin
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
        "processing": true,
        "serverSide": true,
        "pageLength" : 20,
    	"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, 'Todos']],
        "ajax": {
            "url": "<?= site_url('Anexos/getit') ?>",
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
                "title": 'Anexo',
                "data": 'anexo',
                "targets": 1
            },
            {
                "title": 'Nombre',
                "data": 'nombre',
                "targets": 2
            },
            {
                "title": 'Cargo',
                "data": 'cargo',
                "targets": 3,
                "render": function ( data, type, row ) {
                    if(data == null) {
                        return '-'
                    }
                    return data;
                }
            },
            {
                "title": 'Departamento o dirección',
                "data": 'departamento',
                "targets": 4
            },
            {
                "title": 'Email',
                "data": 'email',
                "targets": 5,
                "render": function ( data, type, row ) {
                    if(data == null) {
                        return '-'
                    }
                    return data;
                }
            },
            {
                "title": 'Opciones',
                "data": null,
                "targets": 6,
                "searchable": false,
                "orderable": false,
                "render": function ( data, type, row ) {
                	var link_edit = '<?= site_url('Anexos/editold') ?>/' + row.id; 
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link_edit + '" title="Editar"><i class="ace-icon fa fa-arrow-right"></i></a>';
					var remove_normal = '<a class="red" title="Eliminar" href="#" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '" data-nombre="' + row.anexo + '"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>';

                    options_normal += edit_normal + remove_normal;
                    options_normal += '</div>';

                    var options_responsive = '<div class="hidden-md hidden-lg"><div class="inline pos-rel"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
                     var edit_responsive = '<li><a href="' + link_edit + '" class="tooltip-success" data-rel="tooltip" title="Editar"><span class="green"><i class="ace-icon fa fa-search-square-o bigger-120"></i></span></a></li>';
                    var remove_responsive = '<li><a href="#" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '" data-nombre="' + row.anexo + '" class="tooltip-error" data-rel="tooltip" title="Eliminar"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>';
                    
                    options_responsive += edit_responsive + remove_responsive;
                    options_responsive += '</ul></div></div>';

                    return options_normal;
                }
            }
        ],
        "order": [[ 4, "asc" ]],
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
        url: "<?= site_url('Anexos/deleteold') ?>/" + id,
        type: 'POST',                
        dataType: 'json',
        success:function(response) {
            $.gritter.add({
                title: 'Eliminación exitosa',
                text: 'Se ha eliminado con éxito el anexo',
                class_name: 'gritter-success'
            });
            if(response.type === 'Successful') {
                if(response.name == 'Remove') {
                    $.gritter.add({
                        title: 'Eliminación exitosa',
                        text: 'Se ha eliminado con éxito el anexo',
                        class_name: 'gritter-success'
                    });
                }
            } else if(response.type === 'Error') {
                $.gritter.add({
                    title: 'Error eliminación',
                    text: 'No se ha podido eliminar el anexo.',
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