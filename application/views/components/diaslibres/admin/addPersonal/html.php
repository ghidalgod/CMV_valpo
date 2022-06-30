<h1 class="header smaller lighter blue">
		<i class="ace-icon fa fa-male"></i>
		Agregar nuevo funcionario
</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>
	

<div class="row">
	<div class="col-xs-12 col-sm-6">
		<h2 class="header smaller lighter blue">Información personal</h2>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name" for="nombres"> Nombres: </div>
				<div class="profile-info-value" value="<?=set_value('nombres')?>">
					<span id="nombres"><?php echo form_input($nombres,'','Placeholder = "Nombres..."');?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="rut"> Rut: </div>
				<div class="profile-info-value">
					<span id="rut"><?php echo form_input($rut,'','Placeholder = "Rut sin guión... "');?></span>
					<span for = "digito_rut" id="digito_rut"><?php echo form_input($digito_rut,'','Placeholder = "Digito verificador..."');?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for ="apellido_paterno"> Apellido Paterno: </div>
				<div class="profile-info-value">
					<span id="apellido_paterno"><?php echo form_input($apellido_paterno,'','Placeholder = "Apellido paterno..."');?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="apellido_materno"> Apellido Materno: </div>
				<div class="profile-info-value">
					<span id="apellido_materno"><?php echo form_input($apellido_materno,'','Placeholder = "Apellido materno..."');?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="correo"> Correo: </div>
				<div class="profile-info-value">
					<span id="correo"><?php echo form_input($correo,'','Placeholder = "Correo electronico..."');?></span>
				</div>
			</div>
		</div>
			

	</div>
	<!--
		<p>
			<label for="rut">Rut: </label> <br />
			<?php echo form_input($rut);?>
		</p>
		<p>
			<label for="nombre">nombres: </label> <br />
			<?php echo form_input($nombres);?>
		</p>
		<p>
			<label for="apellido_paterno">Apellido paterno: </label> <br />
			<?php echo form_input($apellido_paterno);?>
		</p>
		<p>
			<label for="apellido_materno">Apellido materno: </label> <br />
			<?php echo form_input($apellido_materno);?>
		</p>
	-->


	<!--
	Aca tengo que ver el tema de los select y como puedo hacer que los datos se guarden en las variables que tengo en el controlador
	para poder verificar que los campos no estan vacios y efectivamente contengan y almacenen la data que le estoy pasando para un posterior
	chequeo de esta.
	
	Tengo que tener especial cuidado con el campo de cargo y el de centro asistencial
	
	-->
	
	
	
	<div class="col-xs-12 col-sm-6">
		<h2 class="header smaller lighter blue">Información de contrato</h2>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name" for="cargo"> Cargo: </div>
				<div class="profile-info-value">
					<select class="chosen-select col-md-9" id="inputCargo" name="cargo" data-placeholder="Buscar Cargo">
						<option value="<?php echo($this->data['cargo']['value']);?>" selected><?php echo($this->data['cargo']['value']);?></option>
		           		<?php foreach( $cargos as $key => $value): ?>
							<option value="<?= $value['CARGO'] ?>" <?php echo set_select('cargo', $value['CARGO']); ?> > <?= $value['CARGO'] ?> </option>
						<?php endforeach; ?>
					</select>
							
					<!--<span id="cargo"><?php echo form_input($cargo);?></span>-->
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="categoria"> Categoria: </div>
				<div class="profile-info-value">
					<span id="categoria"><?php echo form_input($categoria,'','Placeholder = "Categoria..."');?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="nivel"> Nivel: </div>
				<div class="profile-info-value">
					<span id="nivel"><?php echo form_input($nivel,'','Placeholder = "0"');?></span>
				</div>
			</div>
			
			<!--
			<div class="profile-info-row">
				<div class="profile-info-name"> Calidad: </div>
				<div class="profile-info-value">
					<span id="nombre"><?php form_input($calidad);?></span>
				</div>
			</div>
			-->
			
			<!--
			intentar refactorizar el tema del php del centro con un set select para ver si es que me llega a ayudar
			con la wea de que solo muestra el codigo del centro, aunque tengo la sospecha, bueno.. "sospecha", de que la wea pasa porque en la bd se guarda solo el codigo
			
			-->
			<div class="profile-info-row">
				<div class="profile-info-name" for="centro"> Centro: </div>
				<div class="profile-info-value">
					<select class="chosen-select col-md-9" id="inputCentro" name="centro" data-placeholder="Buscar Centro">
						<option value="<?php echo($this->data['centro']['value']);?>" selected><?php echo($this->data['centro']['value']);?> </option>
		           		<?php foreach( $centros as $key => $value): ?>
							<option value="<?=$value['codigo']?>" <?php  echo set_select('centro', $value['codigo']);?> > <?= $value['nombre'] ?> </option>
						<?php endforeach; ?>
					</select>
					<!--<span id="centro"><?php echo form_input($centro);?></span>-->
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="reconocimiento"> Reconocimiento: </div>
				<div class="profile-info-value">
					<span id="reconocimiento"><?php echo form_input($reconosimiento);?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="contrato"> Tipo de Contrato: </div>
				<div class="profile-info-value">
					<select class="chosen-select col-md-9" id="contrato" name="contrato" data-placeholder="Buscar tipo de Contrato">
						<option value="<?php echo($this->data['contrato']['value']);?>" selected><?php echo($this->data['contrato']['value']);?> </option>
		           		<?php foreach( $contratos as $key => $value): ?>
							<option value="<?= $value ?>" <?php echo set_select('contratos', $value); ?> > <?= $value ?> </option>
						<?php endforeach; ?>
					</select>
							
					<!--<span id="cargo"><?php echo form_input($cargo);?></span>-->
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="inicio_contrato"> Inicio de contrato: </div>
				<div class="profile-info-value">
					<span id="inicio_contrato"><?php echo form_input($inicio_contrato);?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name" for="termino_contrato"> Termino de Contrato: </div>
				<div class="profile-info-value">
					<span id="termino_contrato"><?php echo form_input($termino_contrato);?></span>
				</div>
			</div>
		</div>
	</div>
</div>
<!--
		<p>
			<label for="reconocimiento">Reconocimiento: </label> <br />
			<?php echo form_input($reconocimiento);?>
		</p>
		<p>
			<label for="inicio_contrato">Inicio contrato: </label> <br />
			<?php echo form_input($inicio_contrato);?>
		</p>
		<p>
			<label for="termino_contrato">termino contrato: </label> <br />
			<?php echo form_input($termino_contrato);?>
		</p>


		<p>
			<label for="cargo">Cargo: </label><br />
			<?php echo form_input($cargo);?>
		</p>
		<p>
			<label for="categoria">Categoria: </label> <br />
			<?php echo form_input($categoria);?>
		</p>
		<p>
			<label for="nivel">Nivel: </label> <br />
			<?php echo form_input($nivel);?>
		</p>
-->
<br>
<br>
<div class="row">
	<div class="col-sm-12 text-center">
		<button type="button" id="botonVolver" class="btn btn-sm btn-secondary" onclick=" relocate_home()">Volver</button>
		<?php echo form_submit('submit', 'Guardar',"class='btn btn-sm btn-primary' id='botonGuardar'");?></p>
	</div>
</div>


<?php echo form_close();?>
