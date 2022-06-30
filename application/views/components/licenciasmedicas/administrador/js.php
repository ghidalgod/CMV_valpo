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
                "visible": true
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
                "title": 'Acción',
                "data": null,
                "targets": 16,
                "searchable": false,
                "orderable": false,
                "visible": true,
                "render": function ( data, type, row ) {
                    var link_edit = '<?= site_url('LicenciasMedicas/editLicenciaMedica') ?>' + '/' + row.ID;
                    var options_normal = '<div class="hidden-sm hidden-xs action-buttons">';
                    var parametros = `
                    				${row.ID}, 
                    				"${row.FECHA_REGISTRO}",
                    				${row.RUT},
                    				"${row.DIGITO}",
                    				"${row.NOMBRES}",
                    				"${row.APELLIDO_PATERNO}",
                    				"${row.APELLIDO_MATERNO}",
                    				"${row.NLIC}",
                    				"${row.PERIODO}",
                    				${row.DIAS},
                    				"${row.CARGO}",
                    				"${row.CENTRO}",
                    				"${row.CONV.toLowerCase()}",
                    				"${row.TIPO}",
                    				"${row.REPOSO}",
                    				"${row.SALUD}",
                    				"${row.MEDICO}",
                    				"${row.RUT_MEDICO}",
                    				"${row.DIGITO_RUT_MEDICO}"`;

                    var edit = "<button class='blue' title='Editar' onclick='cargarDatos(" + parametros + ")' data-toggle='modal' data-target='#editModal'>Editar</button>";
                    options_normal += edit;
                    options_normal += '</div>';

                    return options_normal;
                }
            },
        ],
		"order": [[ 1, "desc" ]],
		language: {
        	"url": "<?= base_url('assets/js/dataTable.spanish.json') ?>"
    	}
	});
	
	//Carga los datos en el modal para editar
	cargarDatos = function(id, fechaRegistro, rut, digito, nombre, paterno, materno, nlic, periodo, dias, cargo, centro, conv, tipo, reposo, salud, nombreMedico, rutMedico, digitoMedico) {
		document.getElementById("idRegistro").value = id;
		document.querySelector("#nlic > input[name=nlic]").value = nlic;
		document.querySelector("#periodo > input[name=periodo]").value = periodo;
		document.querySelector("#dias > input[name=dias]").value = dias;
		document.querySelector("#dias > select[name=reposo]").value = reposo;
		document.querySelector("#tipo > select[name=tipo]").value = tipo;
		document.querySelector("#salud > select[name=salud]").value = salud;
		document.getElementById("inputNombre").value = nombre;
		document.getElementById("inputApellidoP").value = paterno;
		document.getElementById("inputApellidoM").value = materno;
		document.getElementById("inputRut").value = rut;
		document.getElementById("inputDigito").value = digito;
		document.getElementById("inputCargo").value = cargo;
		document.getElementById("inputCentro").value = centro;
		document.getElementById("inputConv").value = conv;
		document.getElementById("inputNombreMedico").value = nombreMedico;
		document.getElementById("inputRutMedico").value = rutMedico;
		document.getElementById("inputDigitoMedico").value = digitoMedico;
		
        $('.chosen-select').trigger("chosen:updated");
		
		if (conv !== "salud") {
			document.getElementById("conv").style.display = "block";
		} else {
			document.getElementById("conv").style.display = "none";
		}
		document.getElementById("anulacion").checked = false;
	}
	
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

var semaforo = false;
$('#editModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
    var modal = $(this);
    $('.chosen-select').chosen({allow_single_deselect:true});
    $("#inputCentro").chosen().change( function(){
    	var letra = $(this).val().substring(0, 1);
    	if(letra == 'K') {$("#conv").hide();}
    		else { if(letra == 'Z' || letra == 'Y'){ $("#conv").hide();}
    				else $("#conv").show();
    		}

    } );
    // $("#conv").hide();
    $('.input-mask-rut').maskNumber({integer: true});  //Incorpora al input la mascara de miles
    //Oculta todo los mensajes de errores y el efecto de carga del boton Cargar persona
	document.getElementById("ERROR_FORM_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_RUT_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "none";
	document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "none";
	document.getElementById("ERROR_MAIL_SEND_BOTH").style.display = "none";
	document.getElementById("ERROR_MAIL_SEND_CC1").style.display = "none";
	document.getElementById("ERROR_MAIL_SEND_CC2").style.display = "none";
	document.getElementById("ERROR_DAYS").style.display = "none";
	//document.getElementById("skinerOn").style.display = "none";
	document.getElementById("ERROR_SAVE_DB").innerHTML = '';
	//document.getElementById("ERROR_NULL_DB").style.display = "none";
	document.getElementById("nlic").classList.remove("has-error");
	document.getElementById("divNombreMedico").classList.remove("has-error");
	document.getElementById("inputRutMedico").classList.remove("custom-error");
	document.getElementById("inputDigitoMedico").classList.remove("custom-error");
    document.getElementById("periodo").classList.remove("has-error");
    document.getElementById("inputDias").classList.remove("custom-error");
    document.getElementById("selectReposo").classList.remove("custom-error");
    document.getElementById("tipo").classList.remove("has-error");
	document.getElementById("salud").classList.remove("has-error");    
    document.getElementById("nombre").classList.remove("has-error");
    document.getElementById("inputApellidoP").classList.remove("custom-error");
    document.getElementById("inputApellidoM").classList.remove("custom-error");
    document.getElementById("inputRut").classList.remove("custom-error");
    document.getElementById("inputDigito").classList.remove("custom-error");
    document.getElementById("cargo").classList.remove("has-error");
    document.getElementById("centro").classList.remove("has-error");
    document.getElementById("conv").classList.remove("has-error");
	
	//submit del boton guardar
	if(semaforo) return 0;
    semaforo = true;
    $("#formLicenciaMedica").submit(function(e){
        e.preventDefault();
        $("#guardarBtn").button("loading");
        $.ajax({																			//Envia los datos por ajax
            url: "<?= site_url('LicenciasMedicas/editLicenciaMedica') ?>",
            type: "POST",
            data:  new FormData(this),														//envia por post el formulario del boton submit
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function(){
            	console.log('Enviado');
            	//antes de enviar, oculta los mensajes de erorres 
            	document.getElementById("ERROR_FORM_VALIDATOR").style.display = "none";
            	document.getElementById("ERROR_RUT_VALIDATOR").style.display = "none";
            	document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "none";
            	document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "none";
            	document.getElementById("ERROR_MAIL_SEND_BOTH").style.display = "none";
            	document.getElementById("ERROR_MAIL_SEND_CC1").style.display = "none";
            	document.getElementById("ERROR_MAIL_SEND_CC2").style.display = "none";
            	document.getElementById("ERROR_DAYS").style.display = "none";
            	document.getElementById("ERROR_SAVE_DB").innerHTML = '';
                document.getElementById("nlic").classList.remove("has-error");
				document.getElementById("divNombreMedico").classList.remove("has-error");
				document.getElementById("inputRutMedico").classList.remove("custom-error");
				document.getElementById("inputDigitoMedico").classList.remove("custom-error");
                document.getElementById("periodo").classList.remove("has-error");
                document.getElementById("inputDias").classList.remove("custom-error");
                document.getElementById("selectReposo").classList.remove("custom-error");
                document.getElementById("tipo").classList.remove("has-error");
                document.getElementById("salud").classList.remove("has-error");
                document.getElementById("nombre").classList.remove("has-error");
                document.getElementById("inputApellidoP").classList.remove("custom-error");
                document.getElementById("inputApellidoM").classList.remove("custom-error");
                document.getElementById("inputRut").classList.remove("custom-error");
                document.getElementById("inputDigito").classList.remove("custom-error");
                document.getElementById("cargo").classList.remove("has-error");
                document.getElementById("centro").classList.remove("has-error");
                document.getElementById("conv").classList.remove("has-error");
            },
            success: function(response){
            	console.log(response);
            	$("#guardarBtn").button("reset");
                var	data = JSON.parse(response);
                //Dependiendo del mensaje setiado en el controlador, genera notificaciónes
                if(data[0] === 'SUCCESSFUL'){								//se guardaron los datos y mando mail
                    record = JSON.parse(data[1]);
                    modal.modal('toggle');
                    $.gritter.add({
                        title: 'Licencia Médica modificada correctamente',
                        class_name: 'gritter-success'
                    });
					myTable =  $('#dynamic-table').DataTable();
					myTable.ajax.reload(null, false);
					//myTable.row(record.id).data(data).draw();
					// myTable.row.add(data).draw();
					$("#formLicenciaMedica")[0].reset();
					$(".chosen-select").val('').trigger("chosen:updated");
                }
                if(data[0] === "ERROR_FORM_VALIDATOR"){						//Algun campo de los revisados en el controlador no fue rellenado
                    dateForm = JSON.parse(data[1]);
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("ERROR_FORM_VALIDATOR").style.display = "";
                    if(dateForm['numero_licencia'] === '') document.getElementById("nlic").classList.add("has-error");
                    if(dateForm['medico'] === '') document.getElementById("divNombreMedico").classList.add("has-error");
                    if(dateForm['rut_medico'] === '') document.getElementById("inputRutMedico").classList.add("custom-error");
                    if(dateForm['digito_rut_medico'] === '') document.getElementById("inputDigitoMedico").classList.add("custom-error");
                    if(dateForm['periodo'] === '') document.getElementById("periodo").classList.add("has-error");
                    if(dateForm['dias'] === '') document.getElementById("inputDias").classList.add("custom-error");
                    if(dateForm['reposo'] === '') document.getElementById("selectReposo").classList.add("custom-error");
                    if(dateForm['tipo'] === '') document.getElementById("tipo").classList.add("has-error");
                    if(dateForm['salud'] === '') document.getElementById("salud").classList.add("has-error");
                    if(dateForm['nombre'] === '') document.getElementById("nombre").classList.add("has-error");
                    if(dateForm['apellido_paterno'] === '') document.getElementById("inputApellidoP").classList.add("custom-error");
                    if(dateForm['apellido_materno'] === '') document.getElementById("inputApellidoM").classList.add("custom-error");
                    if(dateForm['rut'] === '') document.getElementById("inputRut").classList.add("custom-error");
                    if(dateForm['digito_rut'] === '') document.getElementById("inputDigito").classList.add("custom-error");
                    if(dateForm['cargo'] === '') document.getElementById("cargo").classList.add("has-error");
                    if(dateForm['centro'] === '') document.getElementById("centro").classList.add("has-error");
                    if(dateForm['conv'] === '' || dateForm['conv'] === null) document.getElementById("conv").classList.add("has-error");
                }
                if(data[0] === "ERROR_RUT_VALIDATOR"){						//El rut no coinside con digito
                	modal.animate({scrollTop:0}, 'slow');
					document.getElementById("ERROR_RUT_VALIDATOR").style.display = "";
					document.getElementById("inputRut").classList.add("custom-error");
					document.getElementById("inputDigito").classList.add("custom-error");
                }
                if(data[0] === "ERROR_RUT_MEDICO_VALIDATOR"){						//El rut no coinside con digito
                	modal.animate({scrollTop:0}, 'slow');
					document.getElementById("ERROR_RUT_MEDICO_VALIDATOR").style.display = "";
                    document.getElementById("inputRutMedico").classList.add("custom-error");
                    document.getElementById("inputDigitoMedico").classList.add("custom-error");
                }                
                if(data[0] === "ERROR_DUPLICATE_NLIC"){							//El numero de licencia ya fue registrado
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("nlic").classList.add("has-error");
                    document.getElementById("ERROR_DUPLICATE_NLIC").style.display = "";
                }
                if(data[0] === "ERROR_DB_SAVE"){							//Error desconocido de la base de datos
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
                	console.log(e)
                    document.getElementById("ERROR_SAVE_DB").style.display = "";
                }
                if(data[0] === "ERROR_MAIL_SEND_BOTH"){							//Se guardo pero no se mando mail
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("ERROR_MAIL_SEND_BOTH").style.display = "";
					myTable =  $('#dynamic-table').DataTable();
					myTable.ajax.reload(null, false);
                }
                if(data[0] === "ERROR_MAIL_SEND_CC1"){							//Se guardo pero no se mando mail al centro de costo original
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("ERROR_MAIL_SEND_CC1").style.display = "";
					myTable =  $('#dynamic-table').DataTable();
					myTable.ajax.reload(null, false);
                }
                if(data[0] === "ERROR_MAIL_SEND_CC2"){							//Se guardo pero no se mando mail al centro de costo nuevo
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("ERROR_MAIL_SEND_CC2").style.display = "";
					myTable =  $('#dynamic-table').DataTable();
					myTable.ajax.reload(null, false);
                }
                if(data[0] === "ERROR_DAYS"){
                    modal.animate({scrollTop:0}, 'slow');
                    document.getElementById("inputDias").classList.add("custom-error");
                    document.getElementById("ERROR_DAYS").style.display = "";
                }
            },
            error: function(e){	
            	$("#guardarBtn").button("reset");
            	//Errores de sistema y codigo
            	document.getElementById("ERROR_SAVE_DB").innerHTML = e.responseText;
                console.log(e);
            }
        });
    });
	
});


</script>