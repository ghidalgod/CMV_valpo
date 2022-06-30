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
        "pageLength" : 10,
    	"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, 'Todos']],
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
                "title": 'Descripci√≥n de instructivo',
                "data": 'descripcion',
                "targets": 3,
            },
            {
                "title": 'Link de descarga',
                "data": null,
                "targets": 4,
                "searchable": false,
                "render": function ( data, type, row ) {
                    var link_edit = '<?= site_url('Instructivos/downloadfile')?>/' + row.id; 
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var ir_normal = '<a href="' + link_edit + '"  type="button" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i> Ir al documento</a>';
                    var remove_normal = '<a class="btn btn-danger btn-sm" title="Eliminar" href="#" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '" data-nombre="' + row.nombre + '"><i class="ace-icon fa fa-trash-o"" aria-hidden="true"></i> Eliminar</a>';
                    
                    options_normal += ir_normal + remove_normal;
                    options_normal += '</div>';
                    
                    return options_normal;
                }
            }
        ],
        "order": [[ 0, "asc" ]],
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
    
     //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $('#dynamic-table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
        });
    });
    
    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(this.checked) myTable.row(row).deselect();
        else myTable.row(row).select();
    });

    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });
    
    //And for the first simple table, which doesn't have TableTools or dataTables
    //select/deselect all rows according to table header checkbox
    var active_class = 'active';
    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        });
    });
    
    //select/deselect a row when the checkbox is checked/unchecked
    $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');
        if($row.is('.detail-row ')) return;
        if(this.checked) $row.addClass(active_class);
        else $row.removeClass(active_class);
    });

    /********************************/
    //add tooltip for small view action buttons in dropdown menu
    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
    
    //tooltip placement on right or left
    function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }
    
    /***************/
    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });
});

function btnRemove(id) {
    $.ajax({
        url: "<?= site_url('Instructivos/deleteold') ?>/" + id,
        type: 'POST',                
        dataType: 'json',
        success:function(response) {
            if(response.type === 'Error') {
                $.gritter.add({
                    title: 'Error eliminaci®Æn',
                    text: 'No se ha podido eliminar el instructivo.',
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
