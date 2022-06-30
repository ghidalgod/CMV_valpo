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
        "pageLength" : 20,
    	"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, 'Todos']],
        "ajax": {
            "url": "<?= site_url('Auth/get_users') ?>",
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
                "title": 'Apellidos',
                "data": 'apellido',
                "targets": 2
            },
            {
                "title": 'Email',
                "data": 'email',
                "targets": 3,
                "render": function ( data, type, row ) {
                    if(data == null) {
                        return '-'
                    }
                    return data;
                }
            },
            {
                "title": 'Grupos',
                "data": 'grupo',
                "targets": 4,
            },
            {
                "title": 'Estado',
                "data": 'estado',
                "targets": 5,
                "searchable": false,
                "orderable": false,
                "render": function ( data, type, row ) {                
                    var link_edit;
                    if (data == 1) {
                        link_edit = 'Activo';
                        var link = '<?= site_url('auth/deactivate') ?>' + '/' + row.id;
                    }else if(data == 0){
                        link_edit = 'Inactivo';
                        var link = '<?= site_url('auth/activate') ?>' + '/' + row.id;
                    }
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link + '" title="editar">'+ link_edit +'</a>';
                   
                    options_normal += edit_normal;
                    options_normal += '</div>';

                    return options_normal;
                }
            },
            {
                "title": 'Acción',
                "data": null,
                "targets": 6,
                "searchable": false,
                "orderable": false,
                "render": function ( data, type, row ) {                
                    var link_edit = '<?= site_url('auth/edit_user') ?>' + '/' + row.id;
                    var link_delete = '<?= site_url('auth/eliminar_user') ?>' + '/' + row.id;
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit = '<a class="blue" href="' + link_edit + '" title="Editar">Editar</a>';
                    var del = '<a class="blue" href="' + link_delete + '" title="Eliminar">Eliminar</a>';
                    options_normal += edit +' | ' + del;
                    options_normal += '</div>';

                    return options_normal;
                }
            },
        ],
        "order": [[ 0, "asc" ]],
        "language": {
            "url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
        }
    } );

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

</script>