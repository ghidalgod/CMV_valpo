<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
	//CONFIGURACIÓN DE CKEDITOR 5
	//https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/configuration.html
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
        	removePlugins: [ 'Link', 'Image', 'ImageUpload', 'MediaEmbed', 'ImageStyle', 'EasyImage', 'ImageCaption', 'Heading', 'Table' ],
    	} )
    	.then( editor => {
    		//AJUSTE DE TAMAÑO DE CKEDITOR
    		editor.ui.view.editable.element.style.height = '220px';
		} )
        .catch( error => {
            console.error( error );
        } );
        //console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName )); //PLUGINS DISPONIBLES
</script>

<script>
	$(document).ready( function () {
    	$('#myTable').DataTable({
    		"bAutoWidth": false,
    		data: <?php echo $dataTable ?>,
    		columns: [
    		    { 
    		    	title  : 'id',
					data   : 'id',
					targets: 0,
					visible: false
    		    },
    		    {
				   "title"    : 'Información',
				   "class"    : "details-control",
				   "orderable": false,
				   "targets"  : 1,
		           "render"   : function ( data, type, row ) {
						return '<a class="details-control" role="button" data-html="true" data-toggle="popover" title="'+row.titulo+'" data-content="'+row.cuerpo+'"><i class="ace-icon fa fa-eye bigger-130"></i></a>';
		        	}
        		},
    		    { 
    		    	title  : 'Titulo',
					data   : 'titulo',
					targets: 2,
    		    },
    		    { 
    		    	title  : 'Fecha',
					data   : 'fecha',
					targets: 3,
    		    },
    		    {
    		    	title  : 'Tipo',
    		    	data   : 'tipo',
    		    	targets: 4,
    		    },
    		    {
    		    	title  : 'Creado por',
    		    	data   : 'created_by',
    		    	targets: 5,
    		    },
    		    {
    		    	title    : 'Admin',
    		    	targets  : 6,
    		    	orderable: false,
    		    	render   : function ( data, type, row ) {
    		    			linkEdit   = "<?= site_url('Noticias/editarNoticia')?>/" + row.id;
				            linkDelete = "<?= site_url('Noticias/borrarNoticia')?>/"+row.id;
							return '<a class="blue" title="Editar" href="'+linkEdit+'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>\
								   <a href="#modalEliminar'+row.id+'"  data-toggle="modal" class="red"  title="EliminarNoticia" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>\
				                			<div class="modal fade" name="modelEliminar'+row.id+'" id="modalEliminar'+row.id+'" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				                				<div class="modal-dialog" role="document">\
				                					<div class="modal-content">\
				                						<div class="modal-header">\
				                							<h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>\
				                							<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
				                								<span aria-hidden="true">&times;</span>\
				                							</button>\
				                						</div>\
				                						<div class="modal-body">\
				                							Esta seguro que desea eliminar esta noticia?\
				                						</div>\
				                						<div class="modal-footer">\
				                							<button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>\
	        												<a href="'+linkDelete+'" class="btn btn-info" role="button">Eliminar</a>\
	    												</div>\
	    											</div>\
												</div>\
											</div>'
    		    	}
    		    }
    		]
    	});
	} );
	
	$(function () {
		$('[data-toggle="popover"]').popover({
    		container: 'body'
		})
	})
	
	$('body').on('click', function (e) {
	    $('[data-toggle="popover"]').each(function () {
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            $(this).popover('hide');
	        }
	    });
	});
</script>