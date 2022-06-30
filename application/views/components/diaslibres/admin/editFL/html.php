	<h1 class="header smaller lighter blue">
		<i class="ace-icon fa fa-plane"></i>
		Editar información de feriado legal
	</h1>

		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Nombre: </div>

				<div class="profile-info-value">
					<span id="nombre"><?php echo $nombre;?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> RUN: </div>

				<div class="profile-info-value">
					<span id="run"><?php echo $rut;?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> Disponibles: </div>

				<div class="profile-info-value">
					<span id="dias"><?php echo $disponibles;?></span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Disponibles sin considerar FL actual </div>

				<div class="profile-info-value">
					<span id="dias"> <br><?php echo $no_change;?></span>
				</div>
			</div>
		</div>
		<div class="space-12"></div>
		<div class="row">
			<div id="infoMessage" class="col"><?php echo $message;?></div>
		</div>
		<div>
			<div for="infoMessageWarn"><?php echo $warn?></div>
		</div>
		
		<?php echo form_open_multipart(uri_string());?>
		
		<h3 class="header smaller lighter blue">Duranción</h3>
		<div class="row">
			<div id="fl-data" class="box">
				<div class="col-md-4 form-group col-xs-9">
					<div id="fl-data" class="row">
						<label class="col-md-3 control-label" for="inicio">Inicio: </label>
						<div class="input-group col-md-6">
							<?php echo form_input($inicio);?>
							<span class='input-group-addon'>
								<i class='fa fa-calendar bigger-110'></i>
							</span>
						</div>
					</div>
					<div id="fl-data" class="row">
						<label class="col-md-3 control-label" for="termino">Termino: </label>
						<div class="input-group col-md-6">
							<?php echo form_input($termino);?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
				</div>
				<div id="fl-data" class="col-md-4">
					<div class="btn btn-app btn-sm btn-success" id="contarDias" role="button">
						<div class="row line-height-1">
							<span class="line-height-1 bigger-110" id="dias_habiles"><?php print $dias_habiles;?></span>
								<i id="skinerOn" class="ace-icon fa fa-spinner fa-spin orange bigger-110" style="display:none"></i>
								<br>
								<br>
							<span class="line-height-1 smaller-80">Días Habiles</span>
						</div>
					</div>
				</div>
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
