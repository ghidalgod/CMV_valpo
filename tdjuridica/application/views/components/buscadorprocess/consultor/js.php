 <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
 <script>
 
  $('#buscarCaso').on(ace.click_event, function (event) {
 	numero =  $('#caso-input').val();
 	console.log(numero);
 	
	$.ajax({																		
        url: "<?= site_url('Buscadorprocess/resumenCaso/') ?>"+ numero,
        type: "GET",
        beforeSend : function(){
        },
        success: function(response){
        	data = JSON.parse(response);
        	console.log(data[0]);
        	$('#numero').text(data[0].APP_NUMBER);
        	$('#proceso').text(data[0].APP_PRO_TITLE);
            $('#tarea').text(data[0].APP_TAS_TITLE);
            $('#user').text(data[0].APP_CURRENT_USER);
            $('#create').text(moment(data[0].APP_CREATE_DATE).format("DD/MM/YYYY"));
            $('#recibido').text(moment(data[0].DEL_DELEGATE_DATE).format("DD/MM/YYYY"));
        },
        error: function(e){											
            console.log(e);
        }
    });

 });
 
 $(document).ready(function() {
 	
});
 </script>
