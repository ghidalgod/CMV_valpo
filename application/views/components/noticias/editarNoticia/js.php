<!--Para el funcionamiento de la api de ckeditor-->
<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
<script>
	//https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/configuration.html
	ClassicEditor
        .create( document.querySelector( '#editor' ), {
        	removePlugins: [ 'Link', 'Image', 'ImageUpload', 'MediaEmbed', 'ImageStyle', 'EasyImage', 'ImageCaption', 'Heading', 'Table' ],
    	} )
    	.then( editor => {
    		document.getElementById("spinerOn").style.display = "none";
    		editor.ui.view.editable.element.style.height = '250px';
			//console.log( 'Editor was initialized', editor );
		} )
        .catch( error => {
            console.error( error );
        } );
        //para mostrar los plugins disponibles en la api de ckeditor
        //console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));
</script>