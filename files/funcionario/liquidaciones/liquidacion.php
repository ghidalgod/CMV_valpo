<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	function getPlantilla($data, $rutFormateado, $fechaContrato, $haberes, $descuentos){ 
	$plantilla = "
	<header>
	    <div id='contenedor-parrafo'>
	        <p>CORPORACIÓN MUNICIPAL DE VALPARAÍSO PARA EL DESARROLLO SOCIAL</p>
	        <p>RUT 70.859.400-8</p>
	        <p>ELEUTERIO RAMÍREZ 455</p>
	    </div>
	    <img src='assets/images/logocmv-h.jpg' alt='Logo cmvalparaíso'>
	</header>
	<div>
	    <h5>LIQUIDACIÓN DE REMUNERACIONES</h5>
	    <h6>$data->Mes $data->Año</h6>
	</div>
	<div>
	    <table>
	        <tr>
	            <td class='dato'>Nombre</td>
	            <td>$data->ApellidoPaterno $data->ApellidoMaterno $data->Nombres</td>
	            <td class='dato'>Centro Costo</td>
	            <td>$data->CentroCosto</td>
	        </tr>
	        <tr>
	            <td class='dato'>Cedula de Identidad</td>
	            <td>$rutFormateado</td>
	            <td class='dato'>Hrs Jornada Principal</td>
	            <td>$data->Jornada Hrs $data->CalidadJuridica</td>
	        </tr>
	        <tr>
	            <td class='dato'>Cargo</td>
	            <td>$data->Cargo</td>
	            <td class='dato'>Bienios</td>
	            <td>$data->NumBienioProceso</td>
	        </tr>
	        <tr>
	            <td class='dato'>Fecha contrato</td>h
	            <td>$fechaContrato</td>
	            <td class='dato'>Días Trabajados</td>
	            <td>$data->DiasTrabajados</td>
	        </tr>
	        <tr>
	            <td></td>
	            <td></td>
	            <td class='dato'>Total Imponible</td>
	            <td>$ $data->TotalImponible</td>
	        </tr>
	        <tr>
	            <td></td>
	            <td></td>
	            <td class='dato'>Horas Extras</td>
	            <td>$data->HorasExtras</td>
	        </tr>
	    </table>
	<div>
	<div id='contenedor-tabla-haberes'>
	    <table>
	        <thead>
	            <tr>
	                <th colspan='2'>HABERES</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td class='con-borde'>Descripción</td>
	                <td class='con-borde'>Valor</td>
	            </tr>
	";
	
	foreach ($haberes as $haber) {
		$plantilla .= "
		        <tr>
	                <td>$haber->Nombre</td>
	                <td class='borde-izquierdo'>$haber->ValorCalculado</td>
	            </tr>
		";
	}
	            
	$plantilla .= "</tbody>
	    </table>
	</div>
	<div id='contenedor-tabla-descuentos'>
	    <table>
	        <thead>
	            <tr>
	                <th colspan='2'>DESCUENTOS</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td class='borde-modificado'>Descripción</td>
	                <td class='con-borde'>Valor</td>
	            </tr>";
	            
	    foreach ($descuentos as $descuento) {
			$plantilla .= "
			        <tr>
		                <td>$descuento->Nombre</td>
		                <td class='borde-izquierdo'>$descuento->ValorCalculado</td>
		            </tr>
			";
		}
		
		$plantilla .= "</tbody>
	    </table>
	</div>	
	<div id='totales'>
	    <table id='tabla-total-haberes'>
	        <tr>
	            <td class='negrita'>TOTAL HABERES</td>
	            <td class='negrita'>$data->TotalHaberes</td>
	        </tr>
	    </table>
	    <table id='tabla-subtotal-legal' class='tabla-total-descuentos'>
	        <tr>
	            <td>SubTotal Desctos Legales</td>
	            <td>$data->TotalDescuentosLegales</td>
	        </tr>
	    </table>
	    <table class='tabla-total-descuentos'>
	        <tr>
	            <td>SubTotal Otros Desctos</td>
	            <td>$data->TotalDescuentosVarios</td>
	        </tr>
	    </table>
	    <table class='tabla-total-descuentos'>
	        <tr>
	            <td class='negrita'>TOTAL DESCUENTOS</td>
	            <td class='negrita'>$data->TotalDescuentos</td>
	        </tr>
	    </table>
	    <table class='tabla-total-descuentos'>
	        <tr>
	            <td class='negrita'>LIQUIDO A PAGO</td>
	            <td class='negrita'>$$data->LiquidoAPagar</td>
	        </tr>
	    </table>
	</div>
	<div>
		<br>
		<p>SON : {$data->LiquidoAPagarPalabra} ***********************</p>
		<p>$data->TipoPago</p>
		<br><br><br>
		<p id='parrafo-certifico'>Certifico que he recibido de la Corporación Municipal de Valparaiso, a mi entera satisfacción el saldo indicado en la presente liquidación y no tengo cargo ni cobro posterior que hacer</p>
	</div>
	<div id='firma'>
		<hr>
		<p>Firma Trabajador</p>
	</div>
	";
	return $plantilla;
	}
?>