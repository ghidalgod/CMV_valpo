<div class="row">
	<div class="col-xs-4">
		<h3 class="header smaller lighter green">Estado general</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divActivas" class="infobox infobox-green">
				<div class="infobox-icon">
						<i class="ace-icon fa fa-stethoscope"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['activas'])?></span>
					<div class="infobox-content">Licencias Activas</div>
				</div>
			</div>
				
			<div role="button" id="divVencen7" class="infobox infobox-red">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-stethoscope"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['vencen7dias'])?></span>
					<div class="infobox-content">Vencen en 7 dias</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-4">
		<h3 class="header smaller lighter blue">Últimos 30 dias</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divUltimos30" class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-file-text-o"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['ultimo30dias'])?></span>
					<div class="infobox-content">Cantidad</div>
				</div>
			</div>
				
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-calendar"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= $reporte['ultimo30diastotal']?></span>
					<div class="infobox-content">Total en dias</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-4">
		<h3 class="header smaller lighter purple">Ultimo 180 dias</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divUltimos365" class="infobox infobox-purple">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-file-text-o"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['ultimo365dias'])?></span>
					<div class="infobox-content">Cantidad</div>
				</div>
			</div>
				
			<div class="infobox infobox-purple">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-calendar"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= $reporte['ultimo365diastotal']?></span>
					<div class="infobox-content">Total en dias</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<br>
<button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#addModal">
	<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
	Agregar Nueva Licencia Médica
</button>

<h3 class="header smaller lighter green">Lista de Licencias:</h3>

<div class="clearfix">
	<div class="pull-left">
		<span class="label label-success"> Correo Enviado </span>
		<span class="label label-yellow"> Correo No Enviado </span>
		<span class="label arrowed">Licencia Electronica</span>
		<span class="label label-info">Licencia en papel</span>
	</div>
   <div class="pull-right tableTools-container"></div>
</div>

<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>

<!-- Modal agregar licencia modal-lg -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog"> <!-- <div class="modal-dialog modal-lg"> -->
        <div class="modal-content">
        	<div class="modal-header">
                <div id="ERROR_FORM_VALIDATOR" class="alert alert-danger" >
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                        Complete los campos enmarcados en rojo
                    </strong>
                </div>
                <div id="ERROR_RUT_VALIDATOR" class="alert alert-danger" >
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                        El RUN y digito del funcionario no coinciden.
                    </strong>
                </div>
                <div id="ERROR_RUT_MEDICO_VALIDATOR" class="alert alert-danger" >
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                        El RUN y digito del doctor no coinciden.
                    </strong>
                </div>
                <div id="ERROR_DUPLICATE_NLIC" class="alert alert-danger" >
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                        El numero de licencia ya esta registrado.
                    </strong>
                </div>
                <div id="ERROR_MAIL_SEND" class="alert alert-warning" >
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                        Licencia medica registrada, pero mail no enviado.
                    </strong>
                </div>
                <div id='ERROR_SAVE_DB'>
                </div>

            </div>
			<?= form_open(NULL, 'id="formLicenciaMedica" role="form"'); ?>
	            <div class="modal-body">
	            	<h3 class="header smaller lighter green">
						<i class="ace-icon fa fa-stethoscope"></i>
							Datos de licencia medica
					</h3>
	            	
		            <div class="row">
		            	<div id="nlic" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="nlic">N°Lic: </label>
		            		<input class="col-md-9" name="nlic" type="text" value="">
		            	</div>
		            	
		            	<div id="divNombreMedico" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="medico">Médico: </label>
		            		<input id="inputNombreMedico" class="col-md-9" name="medico" type="text" value="">
		            	</div>
		            	
		            	<div id="divRutMedico" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="rut_medico">Rut: </label>
		            		<input id="inputRutMedico" class="col-md-6 input-mask-rut" name="rut_medico" type="text" maxlength="10" value="">
		            		<label class="col-md-2 control-label no-padding-right" for="digito_rut_medico">Digito: </label>
		            		<input id="inputDigitoMedico" class="col-md-1" name="digito_rut_medico" type="text" maxlength="1" value="">
		            	</div>
		            	
		            	<div id="periodo" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="periodo">Período: </label>
		            		<input class="col-md-4" name="periodo" type="date" value="">
		            	</div>
		            	
		            	<div id="dias" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="dias">Dias: </label>
		            		<input class="col-md-2" name="dias" type="number" value="">
		            		
		            		<div class="col-md-2"></div>
		            		
		            		<label class="col-md-2 control-label no-padding-right" for="reposo">Reposo: </label>
		            		<select class="col-md-2"  name="reposo">
		            			<option value="total"> Total </option>
		            			<option value="parcial"> Parcial </option>
							</select>
		            	</div>
		            	
		            	
		            	<div id="tipo" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="tipo">Tipo: </label>
		            		<select class="chosen-select col-md-9" name="tipo" data-placeholder="Buscar tipo">
		            			<option value="">  </option>
		            			<?php foreach( $tiposLM as $key => $value): ?>
									<option value="<?= $value ?>" > <?= $value ?> </option>
								<?php endforeach; ?>
							</select>
		            	</div>
		            	
		            	<div id="salud" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="salud">Salud: </label>
		            		<select class="chosen-select col-md-9" name="salud" id="inputSalud" data-placeholder="Buscar">
		            			<option value="">  </option>
		            			<?php foreach( $salud as $key => $value): ?>
									<option value="<?= $value ?>" > <?= $value ?> </option>
								<?php endforeach; ?>
							</select>
		            	</div>
		            </div>	
		            
		            <h3 class="header smaller lighter blue">
						<i class="ace-icon fa fa-male"></i>
							Datos de la persona con licencia
					</h3>
					
		            <div class="row">
		            	<div id="nombre" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="nombre">Nombre: </label>
		            		<input id="inputNombre" class="col-md-9" name="nombre" type="text" value="">
		            	</div>
		            	
		            	<div id="apellidos" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="paterno">Apellido Paterno: </label>
		            		<input id="inputApellidoP" class="col-md-3" name="paterno" type="text" value="">
		            		<label class="col-md-2 control-label no-padding-right" for="materno">Materno: </label>
		            		<input id="inputApellidoM" class="col-md-4" name="materno" type="text" value="">
		            	</div>
		            	
		            	<div id="rut" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="rut">Rut: </label>
		            		<input id="inputRut" class="col-md-6 input-mask-rut" name="rut" type="text" maxlength="10" value="">
		            		<label class="col-md-2 control-label no-padding-right" for="digito_rut">Digito: </label>
		            		<input id="inputDigito" class="col-md-1" name="digito_rut" type="text" maxlength="1" value="">
		            	</div>
		            	
		            	<div id="cargo" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="cargo">Cargo: </label>
		            		<select class="chosen-select col-md-9" id="inputCargo" name="cargo" data-placeholder="Buscar Cargo">
		            			<option value="">  </option>
		            			<?php foreach( $cargos as $key => $value): ?>
									<option value="<?= $value['CARGO'] ?>" > <?= $value['CARGO'] ?> </option>
								<?php endforeach; ?>
							</select>
		            	</div>
		            	
		            	<div id='centro'class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="centro">Centro: </label>
		            		<select class="chosen-select col-md-9" id="inputCentro" name="centro" data-placeholder="Buscar centro">
		            			<option value="">  </option>
		            			<?php foreach( $centros as $key => $value): ?>
									<option value="<?= $value['codigo'] ?>" > <?= $value['nombre'] ?> </option>
								<?php endforeach; ?>
							</select>
		            	</div>
		            	
		            	<div id="conv" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label no-padding-right" for="conv">Conv: </label>
		            		<select class="col-md-9" id="inputConv" name="conv">
		            			<option value="normal"> Normal </option>
		            			<option value="docente"> Docente </option>
							</select>
		            	</div>
		            </div>	
				</div>
				
				<div class="modal-footer">
					<i id="ERROR_NULL_DB" class="ace-icon fa fa-times">Sin Coinsidencias.</i>
                    <button id="cargarPersona" type="button" class="btn btn-sm btn-info">
							<i id="skinerOn" class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>
	                        <i id="skinerOff" class="ace-icon fa fa-recycle"></i>
	                        Personal
	                </button>
	                <i id="ERROR_NULL_DB2" class="ace-icon fa fa-times">Sin Coinsidencias.</i>
	                <button id="cargarMedico" type="button" class="btn btn-sm btn-info">
							<i id="skinerOn2" class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>
	                        <i id="skinerOff2" class="ace-icon fa fa-recycle"></i>
	                        <spam id="texto">Medico</spam>
	                </button>
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
	                <button type="submit" class="btn btn-sm btn-primary">
	                		<i id="skinerOn3" class="ace-icon fa fa-spinner fa-spin orange bigger-110" style="display:none"></i>
	                        <i class="ace-icon fa fa-check"></i>
	                        Guardar
	                </button>
	            </div> <!-- Modal Footer -->
            </form>
        </div>
    </div>
</div>