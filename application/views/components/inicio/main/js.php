<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>




<script>
$(document).ready(function() {
  
   var myTable= $('#dynamic-table1'). DataTable({
    //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
  
        "bAutoWidth": false,
        "processing": true,
        "ajax": {
            "url": "<?= site_url('Inicio/getCausas') ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "title": 'ID de Causa',
                "data": 'id',
                "targets": 0,
                "searchable": false,
                "visible": true
            },
            {
                "title": 'RIT/ROL',
                "data": 'rol',
                "targets": 1,
                "searchable": false,
                "visible": true
            },
            {
                "title": 'RUT',
                "data": 'rut',
                "targets": 2,
                "searchable": true                
            },
            {
                "title": 'Nombre del Demandante',
                "data": 'n_demandante',
                "targets": 3,
                "visible": true
            }, 
            {
                "title": 'Fecha de Notificacion /Ingreso',
                "data": 'fecha_not',
                "searchable": false,
                "targets": 4,
                "visible": true,
                "render": function ( data, type, row ) {
                    if(data == null) {
                        return 'Sin información'
                    }
                    //else if(row.etapa == 1){}
                    return data.split("-").reverse().join("-");
                }
            },
            {
                "title": 'Etapa',
                "data": 'etapa',
                "searchable": false,
                "targets": 5,
                "render": function ( data, type, row ) {
                    if (row.etapa == 0 && row.resolucion == 1) return '<span class="label label-success">'+ 'ACOGIDA' +'</span>';
                    if (row.etapa == 0 && row.resolucion == 0) return '<span class="label label-danger">' + 'RECHAZADA'+'</span>';
                    if (row.etapa == 0 && row.resolucion == 2) return '<span class="label label-info">' + 'ACUERDO'+'</span>';
                    if(row.etapa == 1) return 'Denuncia Realizada » Apertura';         //laboral monitorio
                    if(row.etapa == 2) return 'Apertura -> Formulación de Cargo';        //laboral monitorio
                    if(row.etapa == 3) return 'Denuncia Realizada » Audiencia Preparatoria';         //laboral ordinario
                    if(row.etapa == 4) return 'Audiencia Preparatoria » Audiencia al Juicio';        //ordinario
                    if(row.etapa == 5) return 'Audiencia de Juicio » Resolucion';                     //ordinario
                    if(row.etapa == 6) return '<span class="label label-warning">' + 'IMPUGNACION'+'</span>';
                        return '<span class="label label-success">'+ 'En Espera' + '</span>';                                //ordinario
                }
            },
            {
                "title": 'Tipo',
                "data": 'tipo',
                "searchable": false,
                "targets": 6,
                "visible": true,
                
            },
            {
                "title": 'Asignado',
                "data": 'id_asignado',
                "searchable": false,
                "targets": 7,
                "render": function(data,type,row){
                    return row.nombre_asignado + ' ' + row.apellido_asignado;
                }
                
            },
            {
                "title": 'Fecha Siguiente Etapa',
                "data": 'fecha_res',
                "searchable": false,
                "targets": 8,
                "render": function ( data, type, row ) {
                    if (row.etapa == 0 && row.resolucion == 1) return '<span class="label label-danger">'+ 'Terminado' + '</span>';
                    if (row.etapa == 0 && row.resolucion == 0) return '<span class="label label-danger">'+ 'Terminado' + '</span>';
                    if (row.etapa == 0 && row.resolucion == 2) return '<span class="label label-danger">'+ 'Terminado' + '</span>';
                    if(row.etapa == 1){
                        //return addDaystoDate(row.fecha_not,10);
                        return '<span class="label label-success">'+ 'En Espera' + '</span>';
                    }
                    if(row.etapa == 2){
                        return addDaystoDate(row.fecha_res,10); 
                    }
                    if(row.etapa == 3){
                        //return addDaystoDate(row.fecha_prep,5);
                        return '<span class="label label-success">'+ 'En Espera' + '</span>';
                    }
                    if(row.etapa == 4){
                        return addDaystoDate(row.fecha_prep,6);
                        //return addDaystoDate(row.fecha_juicio,3);
                    }
                    if(row.etapa == 5){
                        return addDaystoDate(row.fecha_juicio,3);
                    }
                    if(row.etapa == 6){
                        return '<span class="label label-success">'+ 'En Espera' + '</span>';
                    }

                }
                
            },
            {
                "title": 'Opciones',
                "data": null,
                "targets": 9,
                "searchable": false,
                "orderable": false,
                "render": function ( data, type, row ) {
                    var link_edit = '*';
                    if(row.etapa == 0&&row.tipo=='M') link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_monitorio_id') ?>/' + row.id;
                    if(row.etapa == 0&&row.tipo=='O') link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_ordinario_id') ?>/' + row.id;
                    if(row.etapa == 1) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_monitorio_id') ?>/' + row.id;
                    if(row.etapa == 2) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_monitorio_id') ?>/' + row.id;
                    if(row.etapa == 3) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_ordinario_id') ?>/' + row.id;
                    if(row.etapa == 4) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_ordinario_id') ?>/' + row.id ;
                    if(row.etapa == 5) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_ordinario_id') ?>/' + row.id ;
                    if(row.etapa == 6) link_edit = '<?= site_url('FlujoCausas/Laboral/mostrar_ordinario_id') ?>/' + row.id ;
                    
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link_edit + '" title="Continuar"><i class="ace-icon fa fa-pencil bigger-130"></i></a>';

                    //options_normal += show_details_normal + edit_normal + remove_normal;
                    options_normal += edit_normal;
                    options_normal += '</div>';
                    
                    var options_responsive = '<div class="hidden-md hidden-lg"><div class="inline pos-rel"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
                    var edit_responsive = '<li><a href="' + link_edit + '" class="tooltip-success" data-rel="tooltip" title="Editar"><span class="green"><i class="ace-icon fa fa-search-square-o bigger-120"></i></span></a></li>';
                    //options_responsive += show_details_responsive + edit_responsive + remove_responsive;
                    options_responsive += edit_responsive;
                    options_responsive += '</ul></div></div>';
                    
                    return options_normal + options_responsive;
                }
            },
            {
                "title": 'Notificar',
                "data": 'null',
                "searchable": false,
                "targets": 10,
                "render": function ( data, type, row ) {
                    var link_edit = '*';
                    link_edit = '<?= site_url('FlujoCausas/Laboral/enviar_notificacion') ?>/' + row.id_asignado;
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link_edit + '" title="Continuar"><i class="ace-icon fa fa-envelope bigger-130"></i></a>';
                    options_normal += edit_normal;
                    options_normal += '</div>';
                
                    return options_normal;
                }
                
            },

        ],
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
        }
    } );

    

    $('#myModal').modal('hide');


    /*$('#myModal').on('show.bs.modal', function(event){
        var $button = event.relatedTarget;    
        
        var id = button.data('id');
        console.log(id);
        var modal = $(this);
        
        modal.find('.delete-modal-codigo').text(nombre);
        modal.find('#deleteButton').attr('onclick',"btnRemove("+id+")");
        
        });*/


    $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
    
    var defaultCopyAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
    myTable.buttons().container().appendTo( $('.tableTools-container') );
    
    //style the message box
    var defaultCopyAction = myTable.button(1).action();
    myTable.button(1).action(function (e, dt, button, config) {
        defaultCopyAction(e, dt, button, config);
        $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
    });
    
    var defaultColvisAction = myTable.button(0).action();
    myTable.button(0).action(function (e, dt, button, config) {
        
        defaultColvisAction(e, dt, button, config);
        
        
        if($('.dt-button-collection > .dropdown-menu').length == 0) {
            $('.dt-button-collection')
            .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
            .find('a').attr('href', '#').wrap("<li />")
        }
        $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
    });

    ////
    setTimeout(function() {
        $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
        });
    }, 500);
    
    myTable.on( 'select', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
        }
    } );
    myTable.on( 'deselect', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
        }
    } );

    /////////////////////////////////
    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
    
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

   // window.setTimeout(inicializarDT, 1000);
        
});

    function addDaystoDate(date,days){
        var res = new Date(date);
        res.setDate(res.getDate() - days);          //calcula la suma de dias para la siguiente etapa
        if(res.getDay() == 0){                         //calculo en caso de que el dia sea domingo
            res.setDate(res.getDate() - 2);  
        }
        after_date = res;
        year = after_date.getFullYear();            //saca el año

        month = after_date.getMonth()+01;            //saca el mes
        if(month<10){
            month = "0"+month;
        } 

        aux = after_date.toString();                //a partir del formato original de DATE, saca el 3 caracter de la cadena. 
        exploded = aux.split(' ');
        day = exploded[2];                          //finalmente este es el dia 

        new_date = day + "-" + month + "-" + year;      //guarda el string en la variable y lo devuelve a la tabla. 
        

        return new_date;
    }


 //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------Tabla FLUJO PROCED. SUMARIO SALUD-----------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------


var myTable1 = $('#dynamic-table').DataTable( {
   
        "bAutoWidth": false,
        "processing": true,
        "pageLength" : 20,
        "responsive": true,
        "ajax": {
            "url": "<?= site_url('Inicio/getSumario') ?>",
            "type": "POST"
        },
        "columnDefs": [
            {
                "title": 'ID Sumario',
                "data": 'id',
                "targets": 0,
                "searchable": false,
                "visible": true
            },
            {
                "title": 'Número/Código Sumario',
                "data": 'rol',
                "targets": 1,
                "searchable": true,
                "visible": true
            },
        
            {
                "title": 'Nombre del CESFAM Denunciante',
                "data": 'nom_cesfam',
                "targets": 2,
                "visible": true
            }, 
            {
                "title": 'Fecha Solicitud de Sumario',
                "data": 'fecha_solicitud',
                "targets": 3,
                "visible": true,
                "render": function ( data, type, row ) {
                    if(data == null) {
                        return 'Sin información'
                    }
                    return data.split("-").reverse().join("-");
                }
            },
                
            {
                "title": 'Rut Fiscal Asignado',
                "data": 'rut_fiscal',
                "searchable": true,
                "targets": 4,
                "render": function(data,type,row){
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa >= 2 ){
                    return row.rut_fiscal;
                }               
                return '<span class="label label-success">'+ 'En Espera' + '</span>';

            }
            },
            
            { 
                "title": 'Fecha Notificación Sumario',
                "data": 'fecha_not',
                "targets": 5,
                "visible": true,
                "render": function ( data, type, row ) {
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa >= 2){
                        return data.split("-").reverse().join("-");
                    }
                    return '<span class="label label-success">'+ 'En Espera' + '</span>';
                }
            },

            { 
                "title": 'Plazo Investigación',
                "data": 'plazo_fiscal',
                "targets": 6,
                "visible": true,
                "render": function ( data, type, row ) {
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa >= 2){
                        return data.split("-").reverse().join("-");
                    
                    }
                    return '<span class="label label-success">'+ 'En Espera' + '</span>';
                }
            },

                { 
                "title": 'Contador/Días investigación',
                "data": 'contador',
                "searchable": false,
                "targets": 7,
                "render": function ( data, type, row ) {
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa == 2){  //agregar contador
                        var timeStart = moment(row.fecha_not); //fecha actual hasta el plazo de cierre de investigación
                        var timeEnd = moment(row.plazo_fiscal);
                        return '<span class="label label-secondary">' + timeEnd.diff(timeStart, 'days') + '</span>' ;      
                    }
                    if (row.etapa >= 3 ) return '<span class="label label-secondary">'+ 'Investigación Finalizada' +'</span>';

                    return '<span class="label label-success">'+ 'En Espera' + '</span>';
                }
            },

            {
                "title": 'Etapa',
                "data": 'etapa',
                "searchable": false,
                "targets": 8,
                "render": function ( data, type, row ) {
                    if(row.etapa == 1) return 'Solicitud de Sumario Administrativo';         //si la denuncia es aceptada ->Inicio Sumario
                    if(row.etapa == 2) return 'Visación';        
                    if(row.etapa == 4 && row.sentencia == 3 ) return 'Sobreseimiento';       //DEBE SER APROBADA O RECHAZADA POR EL SECRETARIO GENERAL  
                    if(row.etapa == 5 ) return 'Formulación de cargos';   
                    if(row.etapa == 6) return 'Sumario Administrativo';  // ABSOLUCIÓN O SANCIÓN  
                    if(row.etapa == 7) return 'Dictamen Sumario Fiscal';                    
                    if(row.etapa == 8) return 'etapa8';
                    if(row.etapa == 9) return 'Resolución Fiscal';
                    if(row.etapa == 10) return 'Término Sumario';
                    if(row.etapa == 11) return 'Sumario Administrativo Finalizado';
                    if(row.etapa == 12) return 'Resolución Sumario Administrativo';
                    return '<span class="label label-success">'+ 'En Espera' + '</span>';                                
                }
            },

            {
                "title": 'Estado',
                "data": 'tipo',
                "searchable": false,
                "targets": 9,
                "visible": true,
                "render": function ( data, type, row ) {
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa == 1 && row.sentencia == 2) return '<span class="label label-info">' + 'ACEPTADA'+'</span>';
                    if (row.etapa == 4 && row.sentencia == 3) return '<span class="label label-danger">' + 'SOBRESEIMIENTO'+'</span>';
                    if (row.etapa == 4 && row.sentencia == 4) return '<span class="label label-info">' + 'Formulación de cargos'+'</span>';
                    if (row.etapa == 5) return '<span class="label label-warning">' + 'En espera de Descargos'+'</span>';
                    if (row.etapa == 7) return '<span class="label label-warning">' + 'En espera de Dictamen'+'</span>';
                    if (row.etapa == 9 && row.sentencia == 5) return '<span class="label label-success">' + 'ABSOLUCIÓN'+'</span>';
                    if (row.etapa == 9 && row.sentencia == 6) return '<span class="label label-danger">' + 'SANCIÓN'+'</span>';
                    if (row.etapa == 12 && row.sentencia == 7) return '<span class="label label-success">' + 'AMONESTACIÓN'+'</span>';
                    if (row.etapa == 12 && row.sentencia == 8) return '<span class="label label-info">' + 'MULTA'+'</span>';
                    if (row.etapa == 12 && row.sentencia == 9) return '<span class="label label-warning">' + 'SUSPENSIÓN'+'</span>';
                    if (row.etapa == 12 && row.sentencia == 10) return '<span class="label label-danger">' + 'DESTITUCIÓN'+'</span>';
                    return '<span class="label label-success">'+ 'En Espera' + '</span>'; 
                }
            },

            { 
                "title": 'Fecha Siguiente Etapa',
                "data": 'fecha_sumario',
                "targets": 10,
                "visible": true,
                "render": function ( data, type, row ) {
                    if (row.etapa == 1 && row.sentencia == 1) return '<span class="label label-danger">'+ 'RECHAZADA' +'</span>';
                    if (row.etapa == 1 && row.sentencia == 2) return '<span class="label label-info">' + 'ACEPTADA'+'</span>';
                    if (row.etapa == 2 && row.sentencia == 2) {
                        return '<span class="label label-info">'+ 'Notif. de la resolución: ' + row.fecha_not.split("-").reverse().join("-");                    
                    }
                    if (row.etapa == 4 && row.sentencia == 3) return '<span class="label label-danger">' + 'SOBRESEIMIENTO'+'</span>';
                    if (row.etapa == 6){
                        return '<span class="label label-info">'+ 'Notif. de la resolución: ' + row.fecha_plazos.split("-").reverse().join("-") + '</span>' +'\n'+ '<span class="label label-info">'+ 'Plazo para presentar descargos: ' + row.fecha_defensa.split("-").reverse().join("-") + '</span>';                    
                    }
                    if (row.etapa == 7){
                        return '<span class="label label-info">'+ 'Prórroga: ' + row.fecha_prorroga.split("-").reverse().join("-");                    
                    }
                    if (row.etapa == 9 && row.sentencia == 5) return '<span class="label label-success">' + row.fecha_resolucion.split("-").reverse().join("-") +'</span>';
                    if (row.etapa == 9 && row.sentencia == 6) return '<span class="label label-warning">'+ 'Elevar antecedentes a Secretario General' +'</span>';
                    if (row.etapa == 10) return '<span class="label label-warning">'+ 'En Espera de Resolución Secretario General' +'</span>' +'\n'+ '<span class="label label-info">'+ 'Fecha envío antecedentes: ' + row.fecha_resolucion.split("-").reverse().join("-") + '</span>';                    ;
                    if (row.etapa == 11) return '<span class="label label-success">' + row.fecha_reposicion.split("-").reverse().join("-") +'</span>';
                    if (row.etapa == 12 ) return '<span>'+ 'Finalizada' +'</span>';
                    return '<span class="label label-success">'+ 'En Espera' + '</span>';

                }
            },

          {
                "title": 'Opciones',
                "data": null,
                "targets": 11,
                "searchable": false,
                "orderable": false,
                "render": function ( data, type, row ) {
                    var link_edit = '*';
                    if(row.etapa == 0 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id; 
                    if(row.etapa == 1  && row.sentencia == 1 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id;
                    if(row.etapa == 1  && row.sentencia == 2 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id;
                    if(row.etapa == 2 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id; 
                    if(row.etapa == 3 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id; 
                    if(row.etapa == 4 && row.sentencia == 3) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id;
                    if(row.etapa == 4 && row.sentencia == 4 ) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id;
                    if(row.etapa == 5) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 6) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 7) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 8) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 9) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 10) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 11) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 12) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;
                    if(row.etapa == 13) link_edit = '<?= site_url('Proc/SumarioSalud/mostrarSumario') ?>/' + row.id ;

                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link_edit + '" title="Continuar"><i class="ace-icon fa fa-pencil bigger-130"></i></a>';

                    //options_normal += show_details_normal + edit_normal + remove_normal;
                    options_normal += edit_normal;
                    options_normal += '</div>';
                    
                    var options_responsive = '<div class="hidden-md hidden-lg"><div class="inline pos-rel"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
                    var edit_responsive = '<li><a href="' + link_edit + '" class="tooltip-success" data-rel="tooltip" title="Editar"><span class="green"><i class="ace-icon fa fa-search-square-o bigger-120"></i></span></a></li>';
                    //options_responsive += show_details_responsive + edit_responsive + remove_responsive;
                    options_responsive += edit_responsive;
                    options_responsive += '</ul></div></div>';
                    
                    return options_normal + options_responsive;
                }
            },
            {
                "title": 'Notificar',
                "data": 'null',
                "searchable": false,
                "targets": 12,
                "render": function ( data, type, row ) {
                    var link_edit = '*';
                    link_edit = '<?= site_url('Proc/SumarioSalud/enviarNotificacion') ?>/' + row.id;
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var edit_normal = '<a class="blue" href="' + link_edit + '" title="Continuar"><i class="ace-icon fa fa-envelope bigger-130"></i></a>';
                    options_normal += edit_normal;
                    options_normal += '</div>';
                
                    return options_normal;
                }
                
            },

        ],
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
        }
    } );

    $('#myModal').modal('hide');


    $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
    
    var defaultCopyAction = myTable1.button(0).action();
	myTable1.button(0).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
    myTable1.buttons().container().appendTo( $('.tableTools-container') );
    
    //style the message box
    var defaultCopyAction = myTable1.button(1).action();
    myTable1.button(1).action(function (e, dt, button, config) {
        defaultCopyAction(e, dt, button, config);
        $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
    });
    
    var defaultColvisAction = myTable1.button(0).action();
    myTable1.button(0).action(function (e, dt, button, config) {
        
        defaultColvisAction(e, dt, button, config);
        
        
        if($('.dt-button-collection > .dropdown-menu').length == 0) {
            $('.dt-button-collection')
            .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
            .find('a').attr('href', '#').wrap("<li />")
        }
        $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
    });

    ////
    setTimeout(function() {
        $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
        });
    }, 500);
    
    myTable1.on( 'select', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable1.row( index ).node() ).find('input:checkbox').prop('checked', true);
        }
    } );
    myTable1.on( 'deselect', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable1.row( index ).node() ).find('input:checkbox').prop('checked', false);
        }
    } );

    /////////////////////////////////
    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
    
    //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $('#dynamic-table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable1.row(row).select();
            else  myTable1.row(row).deselect();
        });
    });
    
    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(this.checked) myTable1.row(row).deselect();
        else myTable1.row(row).select();
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

    //window.setTimeout(inicializarDT, 1000);
        




</script>