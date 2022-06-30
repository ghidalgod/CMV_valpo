<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.gritter.min.js') ?>"></script>
<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>

<script src="<?= base_url('assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/js/buttons.print.min.js') ?>"></script>

<script>

//Libreria cargada de forma manual, para incluir una mascara para las input numericos y que se autocomplete el punto de las
//cantidades en miles, Ejemplo: si se escribe 1000, auto completa el punto quedando 1.000
//Cuando se rescata el input con la mascara este retorna la cantidad numerica incluido los puntos(Al controler llega 1.000)
(function (factory) {

    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery || Zepto);
    }

}(function($) {

    $.fn.maskNumber = function(options) {

        var settings = $.extend({}, $.fn.maskNumber.defaults, options);
        settings = $.extend(settings, options);
        settings = $.extend(settings, this.data());

        this.keyup(function() {
            format(this, settings);
        });
        
        return this;
    };
	//Caracter que usara para auto completar el separador de miles y centimos
    $.fn.maskNumber.defaults = {
        thousands: ".",
        decimal: ",",
        integer: false,
        allowNegative: false
    };

    function format(input, settings) {
        var inputValue = input.value;
        inputValue = removeNonDigits(inputValue, settings.allowNegative);
        if (!settings.integer) {
            inputValue = addDecimalSeparator(inputValue);
        }
        inputValue = addThousandSeparator(inputValue, settings);
        inputValue = removeLeftZeros(inputValue);
        applyNewValue(input, inputValue);
    }
    
    function removeNonDigits(value, allowNegative) {
        return ((allowNegative && value[0] === "-") ? "-" : "") + value.replace(/\D/g, "");
    }
    
    function addDecimalSeparator(value, settings) {
        value = value.replace(/(\d{2})$/, settings.decimal.concat("$1"));
        value = value.replace(/(\d+)(\d{3}, \d{2})$/g, "$1".concat(settings.thousands).concat("$2"));
        return value;
    }
    
    function addThousandSeparator(value, settings) {
        var totalThousandsPoints = (value.length - 3) / 3;
        var thousandsPointsAdded = 0;
        while (totalThousandsPoints > thousandsPointsAdded) {
            thousandsPointsAdded++;
            value = value.replace(/(\d+)(\d{3}.*)/, "$1".concat(settings.thousands).concat("$2"));
        }
        
        return value;
    }
    
    function removeLeftZeros(value) {
        return value.replace(/^(0)(\d)/g,"$2");
    }
    
    function applyNewValue(input, newValue) {
        if (input.value != newValue) {
            input.value = newValue;
        }
        $(input).trigger('change', input.value);
    }

})); //Fin mascara input.

$(document).ready(function() {
	
	var filtroActivos = "<?php
							if(empty($reporte['activas'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['activas'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroVencen7 = "<?php
							if(empty($reporte['vencen7dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['vencen7dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroUltimos30 = "<?php
							if(empty($reporte['ultimo30dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['ultimo30dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	var filtroUltimos365 = "<?php
							if(empty($reporte['ultimo30dias'])) echo "";
								else{
									$filtro = "(";
									foreach($reporte['ultimo365dias'] as $key => $value){
										$filtro .= $value['id']."|";
									}
									echo substr($filtro, 0, -1) . ")";
								}
						?>";
	
	var estadoBotonActivas = false;
	var estadoBoton7 = false;
	var estadoBoton30 = false;
	var estadoBoton365 = false;
	
    var myTable = $('#dynamic-table').DataTable( {
        "bAutoWidth": false,
		"ajax": {
            "url": "<?= site_url('LicenciasMedicas/getLicenciasMedicas') ?>",
            "type": "GET"
        },
		"columnDefs": [
            {
            	"title": 'id',
            	"data": 'ID',
                "targets": 0,
                "visible": false
            },
            {
            	"title": 'Ingresado',
            	"data": 'FECHA_REGISTRO',
            	"iDataSort": 15,
                "targets": 1,
                "render": function(data, type, row){
                	if(row.CORREO == 1) return '<span class="label label-success">' + moment(row.FECHA_REGISTRO).format("DD/MM/YY") + '</span>';
                    if(row.CORREO == 0) return '<span class="label label-yellow">' + moment(row.FECHA_REGISTRO).format("DD/MM/YY") + '</span>';
                }
            },
            {
            	"title": 'RUN',
                "targets": 2,
                "render": function ( data, type, row ) {
                	num = row.RUT;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
                	return num +'-'+ row.DIGITO;
                }
                
            },
            {
            	"title": 'Nombre',
            	"data": 'NOMBRE',
                "targets": 3,
                "render": function ( data, type, row ) {
                	return row.NOMBRES +' '+ row.APELLIDO_PATERNO +' '+ row.APELLIDO_MATERNO;
                }
                
            },
            {
            	"title": 'N°Lic',
            	"data": 'NLIC',
                "targets": 4,
                "render": function(data, type, row){
                	if(row.NLIC.charAt(row.NLIC.length - 2) === '-') return '<span class="label arrowed">' + row.NLIC + '</span>';
	                    else return '<span class="label label-info">' + row.NLIC + '</span>';
                }
            },
            {
            	"title": 'Período',
            	"data": 'PERIODO',
            	"iDataSort": 16,
                "targets": 5,
                "render": function(data, type, row){
                	return moment(row.PERIODO).format("DD/MM/YY");
                }
            },
            {
            	"title": 'Días',
            	"data": 'DIAS',
                "orderable": false,
                "targets": 6,
            },
            {
            	"title": 'Cargo',
            	"data": 'CARGO',
                "targets": 7,
            },
            {
            	"title": 'ESTAB',
            	"data": 'ESTAB',
            	"orderable": false,
                "targets": 8,
            },
            {
            	"title": 'CONV',
            	"data": 'CONV',
                "targets": 9,
            },
            {
            	"title": 'Tipo',
            	"data": 'TIPO',
                "targets": 10
            },
            {
            	"title": 'Reposo',
            	"data": 'REPOSO',
            	"orderable": false,
                "targets": 11
            },
            {
            	"title": 'Salud',
            	"data": 'SALUD',
                "targets": 12
            },
            {
            	"title": 'Nombre Médico',
            	"data": 'MEDICO',
                "targets": 13,
            },
            {
            	"title": 'Run Médico',
                "targets": 14,
                "render": function ( data, type, row ) {
                	num = row.RUT_MEDICO;
                	num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
					num = num.split('').reverse().join('').replace(/^[\.]/,'');
                	return num +'-'+ row.DIGITO_RUT_MEDICO;
                }
            },
            {
            	"title": 'FILTER_DATE',
            	"data": 'FECHA_REGISTRO',
                "targets": 15,
                "visible": false
            },
            {
            	"title": 'FILTER_DATE',
            	"data": 'PERIODO',
                "targets": 16,
                "visible": false
            },
        ],
		"order": [[ 0, "desc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al portapapeles</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"exportOptions": {
				"columns": ':not(:first):not(:last)'
			}
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
			"className": "btn btn-white btn-primary btn-bold",
			"autoPrint": true,
			"message": '<h2>Licencias Medicas</h2>',
			"exportOptions": {
				"columns": ':not(:first):not(:last)'
			}
		  }
		]
	} );
	
	var defaultCopyAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
	
	myTable.buttons().container().appendTo( $('.tableTools-container') );
	
	$('#divActivas').click(function(){
		if(estadoBotonActivas){
			resetSearch();
		}	else {
				resetSearch();
				$('#divActivas').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroActivos, true).draw();
				estadoBotonActivas = true;
			}
	});
	
	$('#divVencen7').click(function(){
		if(estadoBoton7){
			resetSearch();
		}	else{
				resetSearch();
				$('#divVencen7').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroVencen7, true).draw();
				estadoBoton7 = true;
				
			}
	});
	
	$('#divUltimos30').click(function(){
		if(estadoBoton30){
			resetSearch();
		}	else{
				resetSearch();
				$('#divUltimos30').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroUltimos30, true).draw();
				estadoBoton30 = true;
				
			}
	});
	
	$('#divUltimos365').click(function(){
		if(estadoBoton365){
			resetSearch();
		}	else{
				resetSearch();
				$('#divUltimos365').css("background-color", "rgb(102, 204, 255, 0.5)");
				myTable.columns(0).search(filtroUltimos365, true).draw();
				estadoBoton365 = true;
				
			}
	});
	
	function resetSearch(){
		myTable.columns().search("").draw();
		
		estadoBotonActivas = false;
		$('#divActivas').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton7 = false;
		$('#divVencen7').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton30 = false;
		$('#divUltimos30').css("background-color", "rgb(255, 255, 255)");
		
		estadoBoton365 = false;
		$('#divUltimos365').css("background-color", "rgb(255, 255, 255)");
	}
	
});
var modal;
$('#addModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
    modal = $(this);
    $('.chosen-select').chosen({allow_single_deselect:true});
    $("#inputCentro").chosen().change( function(){
    	var letra = $(this).val().substring(0, 1);
    	if(letra == 'K') {$("#conv").hide();}
    		else { if(letra == 'Z' || letra == 'Y'){ $("#conv").hide();}
    				else $("#conv").show();
    		}

    } );
    $("#conv").hide();
    $('.input-mask-rut').maskNumber({integer: true});  //Incorpora al input la mascara de miles
    //Oculta todo los mensajes de errores y el efecto de carga del boton Cargar persona
	document.getElementById("ERROR_FORM_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_RUT_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "none";
	document.getElementById("ERROR_MAIL_SEND").style.display = "none";
	document.getElementById("skinerOn").style.display = "none";
	document.getElementById("skinerOn2").style.display = "none";
	document.getElementById("ERROR_SAVE_DB").innerHTML = '';
	document.getElementById("ERROR_NULL_DB").style.display = "none";
	document.getElementById("ERROR_NULL_DB2").style.display = "none";
	document.getElementById("nlic").classList.remove("has-error");
    document.getElementById("periodo").classList.remove("has-error");
    document.getElementById("dias").classList.remove("has-error");
    document.getElementById("nombre").classList.remove("has-error");
    document.getElementById("apellidos").classList.remove("has-error");
    //document.getElementById("apellidos").classList.remove("has-error");
    document.getElementById("rut").classList.remove("has-error");
    //document.getElementById("rut").classList.remove("has-error");
    document.getElementById("cargo").classList.remove("has-error");
    document.getElementById("centro").classList.remove("has-error");
    document.getElementById("divNombreMedico").classList.remove("has-error");
    document.getElementById("divRutMedico").classList.remove("has-error");
    //document.getElementById("conv").classList.remove("has-error");

});

$('#cargarPersona').on("click", function(){
	var rut = document.getElementById("inputRut").value;
	var digito = document.getElementById("inputDigito").value;
	patron = ".",
	rut = rut.replace(patron, "");
	rut = rut.replace(patron, "");
	$.ajax({
        url: "<?= site_url('LicenciasMedicas/getPersonaRutProcess') ?>/" + rut +'/'+ digito,
        type: "GET",
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
			document.getElementById("ERROR_NULL_DB").style.display = "none";
			document.getElementById("skinerOn").style.display = "";
			document.getElementById("skinerOff").style.display = "none";
        },
        success: function(response){
        	console.log(response);
            var	data = JSON.parse(response);
            if(data[0] === 'SUCCESSFUL'){
            	//persona = JSON.parse(data[1]);
            	document.getElementById("inputNombre").value = data[1].nombre;
            	document.getElementById("inputApellidoP").value = data[1].apellido_paterno;
            	document.getElementById("inputApellidoM").value = data[1].apellido_materno;
				document.getElementById("inputCargo").value = data[1].cargo;
				document.getElementById("inputCentro").value = data[1].centro;
				$('#inputSalud').val(data[1].salud);
    			$('#inputSalud').trigger("chosen:updated");
				$('#inputCargo').val(data[1].cargo);
    			$('#inputCargo').trigger("chosen:updated");
				$('#inputCentro').val(data[1].centro);
    			$('#inputCentro').trigger("chosen:updated");
            }
            
            if(data[0] === 'ERROR_NULL_DB'){
            	//persona = JSON.parse(data[1]);
				document.getElementById("ERROR_NULL_DB").style.display = "";
            }
            
            document.getElementById("skinerOff").style.display = "";
			document.getElementById("skinerOn").style.display = "none";
        },
        error: function(e){
        	document.getElementById("skinerOff").style.display = "";
			document.getElementById("skinerOn").style.display = "none";
        	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            console.log(e);
            //$("#err").html(e).fadeIn();
        }
    });
});
	
$('#cargarMedico').on("click", function(){
	var rut = document.getElementById("inputRutMedico").value;
	patron = ".",
	rut = rut.replace(patron, "");
	rut = rut.replace(patron, "");
	$.ajax({
        url: "<?= site_url('LicenciasMedicas/getMedicoRut') ?>/" + rut ,
        type: "GET",
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
			document.getElementById("ERROR_NULL_DB2").style.display = "none";
			document.getElementById("skinerOn2").style.display = "";
			document.getElementById("skinerOff2").style.display = "none";
        },
        success: function(response){
        	console.log(response);
            var	data = JSON.parse(response);
            if(data[0] === 'SUCCESSFUL'){
            	//persona = JSON.parse(data[1]);
            	document.getElementById("inputNombreMedico").value = data[1].medico;
            	document.getElementById("inputDigitoMedico").value = data[1].digito_rut_medico;
            }
            
            if(data[0] === 'ERROR_NULL_DB'){
            	//persona = JSON.parse(data[1]);
				document.getElementById("ERROR_NULL_DB2").style.display = "";
            }
            
            document.getElementById("skinerOff2").style.display = "";
			document.getElementById("skinerOn2").style.display = "none";
        },
        error: function(e){
        	document.getElementById("skinerOff2").style.display = "";
			document.getElementById("skinerOn2").style.display = "none";
        	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            console.log(e);
            //$("#err").html(e).fadeIn();
        }
    });
});
	
$("#formLicenciaMedica").submit(function(e){
    e.preventDefault();
    $.ajax({																			//Envia los datos por ajax
        url: "<?= site_url('LicenciasMedicas/addLicenciaMedica') ?>",
        type: "POST",
        data:  new FormData(this),														//envia por post el formulario del boton submit
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
        	document.getElementById("skinerOn3").style.display = "";
        	//antes de enviar, oculta los mensajes de erorres 
        	document.getElementById("ERROR_FORM_VALIDATOR").style.display = "none";
        	document.getElementById("ERROR_RUT_VALIDATOR").style.display = "none";
        	document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "none";	
        	document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "none";
        	document.getElementById("ERROR_MAIL_SEND").style.display = "none";
        	document.getElementById("ERROR_SAVE_DB").innerHTML = '';
            document.getElementById("nlic").classList.remove("has-error");
            document.getElementById("periodo").classList.remove("has-error");
            document.getElementById("dias").classList.remove("has-error");
            document.getElementById("nombre").classList.remove("has-error");
            document.getElementById("apellidos").classList.remove("has-error");
            //document.getElementById("apellidos").classList.remove("has-error");
            //document.getElementById("rut").classList.remove("has-error");
            document.getElementById("rut").classList.remove("has-error");
            document.getElementById("cargo").classList.remove("has-error");
            document.getElementById("centro").classList.remove("has-error");
            document.getElementById("divNombreMedico").classList.remove("has-error");
		    document.getElementById("divRutMedico").classList.remove("has-error");	
            //document.getElementById("conv").classList.remove("has-error");
        },
        success: function(response){
        	console.log(response);
        	document.getElementById("skinerOn3").style.display = "none";
            var	data = JSON.parse(response);
            //Dependiendo del mensaje setiado en el controlador, genera notificaciónes
            if(data[0] === 'SUCCESSFUL'){								//se guardaron los datos y mando mail
                record = JSON.parse(data[1]);
                //console.log(record);
                modal.modal('toggle');
                $.gritter.add({
                    title: 'Licencia Médica ingresada correctamente',
                    class_name: 'gritter-success'
                });
                data = {
						"ID": record.id,
						"FECHA_REGISTRO": record.fecha_registro,
						"RUT": record.rut,
						"DIGITO": record.digito_rut,
						"NOMBRES": record.nombre,
						"APELLIDO_PATERNO": record.apellido_paterno,
						"APELLIDO_MATERNO":	record.apellido_materno,
						"NLIC": record.numero_licencia,
						"PERIODO": record.periodo,
						"DIAS": record.dias,	
						"CARGO": record.cargo,
						"ESTAB": record.centro,
						"CONV": record.conv,
						"CORREO": record.correo_centro,
						"TIPO": record.tipo,
						"REPOSO": record.reposo,
						"SALUD": record.salud,
						"MEDICO": record.medico,
						"RUT_MEDICO": record.rut_medico,
						"DIGITO_RUT_MEDICO": record.digito_rut_medico
				}
				myTable =  $('#dynamic-table').DataTable();
				myTable.row.add(data).draw();
				$("#formLicenciaMedica")[0].reset();
				$(".chosen-select").val('').trigger("chosen:updated");
            }
            if(data[0] === "ERROR_FORM_VALIDATOR"){						//Algun campo de los revisados en el controlador no fue rellenado
                dateForm = JSON.parse(data[1]);
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_FORM_VALIDATOR").style.display = "";
                if(dateForm['numero_licencia'] === '') document.getElementById("nlic").classList.add("has-error");
                if(dateForm['periodo'] === '') document.getElementById("periodo").classList.add("has-error");
                if(dateForm['dias'] === '') document.getElementById("dias").classList.add("has-error");
                if(dateForm['nombre'] === '') document.getElementById("nombre").classList.add("has-error");
                if(dateForm['apellido_paterno'] === '') document.getElementById("apellidos").classList.add("has-error");
                if(dateForm['apellido_materno'] === '') document.getElementById("apellidos").classList.add("has-error");
                if(dateForm['rut'] === '') document.getElementById("rut").classList.add("has-error");
                if(dateForm['digito_rut'] === '') document.getElementById("rut").classList.add("has-error");
                if(dateForm['cargo'] === '') document.getElementById("cargo").classList.add("has-error");
                if(dateForm['centro'] === '') document.getElementById("centro").classList.add("has-error");
                if(dateForm['medico'] === '') document.getElementById("divNombreMedico").classList.add("has-error");
                if(dateForm['rut_medico'] === '') document.getElementById("divRutMedico").classList.add("has-error");
                if(dateForm['digito_rut_medico'] === '') document.getElementById("divRutMedico").classList.add("has-error");
                //if(dateForm['conv'] === '') document.getElementById("conv").classList.add("has-error");
            }
            if(data[0] === "ERROR_RUT_VALIDATOR"){						//El rut no coinside con digito
            	modal.animate({scrollTop:0}, 'slow');
				document.getElementById("ERROR_RUT_VALIDATOR").style.display = "";
				document.getElementById("rut").classList.add("has-error");
            }
            if(data[0] === "ERROR_RUT_MEDICO_VALIDATOR"){						//El rut no coinside con digito
            	modal.animate({scrollTop:0}, 'slow');
				document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "";
				document.getElementById("divRutMedico").classList.add("has-error");
            }
            if(data[0] === "ERROR_DUPLICATE_NLIC"){							//El numero de licencia ya fue registrado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("nlic").classList.add("has-error");
                document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "";
            }
            if(data[0] === "ERROR_DB_SAVE"){							//El numero de licencia ya fue registrado
                modal.animate({scrollTop:0}, 'slow');
                document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            	console.log(e)
                document.getElementById("ERROR_DB_SAVE").style.display = "";
            }
            if(data[0] === "ERROR_MAIL_SEND"){							//Se guardo pero no se mando mail
                record = JSON.parse(data[1]);
                //console.log(record);
                modal.modal('toggle');
                $.gritter.add({
                    title: 'Licencia Médica ingresada sin notificación',
                    class_name: 'gritter-success'
                });
                data = {
						"ID": record.id,
						"FECHA_REGISTRO": record.fecha_registro,
						"RUT": record.rut,
						"DIGITO": record.digito_rut,
						"NOMBRES": record.nombre,
						"APELLIDO_PATERNO": record.apellido_paterno,
						"APELLIDO_MATERNO":	record.apellido_materno,
						"NLIC": record.numero_licencia,
						"PERIODO": record.periodo,
						"DIAS": record.dias,	
						"CARGO": record.cargo,
						"ESTAB": record.centro,
						"CONV": record.conv,
						"CORREO": record.correo_centro,
						"TIPO": record.tipo,
						"REPOSO": record.reposo,
						"SALUD": record.salud,
						"MEDICO": record.medico,
						"RUT_MEDICO": record.rut_medico,
						"DIGITO_RUT_MEDICO": record.digito_rut_medico
				}
				myTable =  $('#dynamic-table').DataTable();
				myTable.row.add(data).draw();
				$("#formLicenciaMedica")[0].reset();
				$(".chosen-select").val('').trigger("chosen:updated");
            }
        },
        error: function(e){												//Errores de sistema y codigo
        	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
            console.log(e);
        }
    });
});

$('#addModal').on('hidden.bs.modal', function (event) {
    $(".chosen-select").val('').trigger("chosen:updated");
    $(this).find('form').trigger('reset');
});
</script>