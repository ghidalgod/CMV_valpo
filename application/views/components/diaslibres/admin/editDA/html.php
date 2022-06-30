		<h1 class="header smaller lighter green">
			<i class="ace-icon fa fa-plane"></i>
			Editar información de día administrativo
		</h1>

		<div class="row">
			<div id="infoMessage" class="col"><p ><?php echo $message;?></p></div>
		</div>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Nombre </div>

				<div class="profile-info-value">
					<span id="nombre"><?php echo $data_dadm['nombre'];?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> RUN </div>

				<div class="profile-info-value">
					<span id="run"><?php echo $data_dadm['rut'];?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Disponibles </div>

				<div class="profile-info-value">
					<span id="dias"><?php echo $data_dadm['disponible'];?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Disponibles sin considerar DA actual</div>

				<div class="profile-info-value">
					<span id="dias"> <br><?php echo $no_change;?></span>
				</div>
			</div>
		</div>
		
		<div class="space-12"></div>
		
		<?php echo form_open_multipart(uri_string());?>
		<h3 class="header smaller lighter blue">Información</h3>
		<div id="da-data" class="box">
			<div class="form-group col-xs-9">
				<div class="row form-group">
					<label class="col-md-3 control-label" for="dias">Días a solicitar: </label>
					<?php echo form_dropdown('dias',$options,$seleccion,$extra_sl);?>
				</div>
				<div class="row form-group">
					<label class="col-md-3 control-label" for="inicio">Inicio: </label>
					<div class="input-group col-md-6">
						<?php echo form_input($inicio);?>
						<span class='input-group-addon'>
							<i class='fa fa-calendar bigger-110'></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="infoMessage" class="col">
				<p><?php echo validation_errors(); ?></p> 
			</div>
		</div>
		<h2 class="header smaller lighter blue">Documento</h2>

		<div class="row">
			<div class="box">
				<div class="col-md-6">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Adjuntar solicitud</h4>
						</div>
				
						<div class="widget-body">
							<div class="widget-main">
								<div id="documento" class="form-group">
									<div class="col-xs-12">
										<input name="documento_fl" type="file" id="id-input-file_fl" />
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<dvi class="col">
				<p id="reg-form"><?php echo form_submit('submit', 'Actualizar',"class='btn btn-sm btn-primary'");?></p>
			</dvi>
		</div>
		<?php echo form_close();?>