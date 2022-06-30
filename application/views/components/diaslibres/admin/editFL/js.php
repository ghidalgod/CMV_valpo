<script>
  
 $(document).ready(function() {
 	
 	$('#id-input-file_fl').ace_file_input({
			no_file: 'Sin archivo seleccionado ...',
			btn_choose: 'Seleccionar',
			btn_change: 'Cambiar',
			droppable: false,
			onchange: null,
			thumbnail: false, //| true | large
		});
});

var dias_habiles = document.getElementById('dias_habiles').value;

 $('#contarDias').on(ace.click_event, function (event) {
	var inicio  = document.getElementById('inicio').value;
	var termino = document.getElementById('termino').value;
	if(inicio !== '' && termino !== ''){
		$.ajax({																
	            url: "<?php echo site_url('DiasLibres/calcularFL/')?>"+ inicio +'/'+ termino,
	            data: { inicio:inicio, termino:termino },
	            type: "GET",
	
	            beforeSend : function(){
	            	$('#dias_habiles').text("");
	            	document.getElementById("skinerOn").style.display = "";
	            },
	            success: function(response){
	           		$('#dias_habiles').text(response);
	                document.getElementById("skinerOn").style.display = "none";	
	
	            },
	            error: function(e){	
	            	alert("ERROR:",e);
	                console.log(e);
	            }
        });
	}
});

document.getElementById("dias_habiles").readOnly = true;
</script>