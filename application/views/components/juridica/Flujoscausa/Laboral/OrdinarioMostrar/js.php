<!-- JS code -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js">
</script>
<!--JS below-->


<!--modal-->
<script>
  $(document).ready(function() {
    $("#myModal").modal();
    $("#asignar").modal();
  });

  console.log($("#asignado").value);


  $('#id-input-file').ace_file_input({
        no_file: 'Sin archivos',
        btn_choose: 'Seleccionar',
        btn_change: 'Cambiar',
        uploadMultiple: true,
        parallelUploads: 10,
        droppable: true,
        //whitelist:'xlxs'
        //blacklist:'exe|php'
        //onchange:''
        //
    }).on('change', function() {
        var files = $(this).data('ace_input_files');
        if(files.length > 1) $(this).ace_file_input('show_file_list',[files.length + ' Archivos seleccionados']);
        else $(this).ace_file_input('show_file_list',[files[0].name]);
    });

</script>
