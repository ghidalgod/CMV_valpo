<div id="infoMessage"><?php echo $message;?></div>

<div class="space-12"></div>

<div id="user-profile-3" class="user-profile row">
	<?= form_open_multipart(site_url('PerfilUser/ajustes'), 'class="form-horizontal" role="form"') ?>
	<form class="form-horizontal">
		<div class="tabbable">
			<ul class="nav nav-tabs padding-16">
				<li class="active">
					<a data-toggle="tab" href="#edit-basic">
						<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
						Información basica
					</a>
				</li>

<!--				<li>
					<a data-toggle="tab" href="#edit-settings">
						<i class="purple ace-icon fa fa-cog bigger-125"></i>
						Ajustes
					</a>
				</li>
-->
				<li>
					<a data-toggle="tab" href="#edit-password">
						<i class="blue ace-icon fa fa-key bigger-125"></i>
						Contraseña
					</a>
				</li>
			</ul>

			<div class="tab-content profile-edit-tab-content">
				<div id="edit-basic" class="tab-pane in active">
					<h4 class="header blue bolder smaller">General</h4>

					<div class="row">
<!--						<div class="col-xs-12 col-sm-4">
							<input type="file" name="userFileD" />
						</div>
-->
						<div class="vspace-12-sm"></div>

						<div class="col-xs-12 col-sm-8">
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="form-field-username">Nombres</label>

								<div class="col-sm-8">
									<input class="col-xs-12 col-sm-10" type="text" id="form-field-username" name="nombres" value="<?= $nombres ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="form-field-username">Apellidos</label>

								<div class="col-sm-8">
									<input class="col-xs-12 col-sm-10" type="text" id="form-field-username" name="apellidos" value="<?= $apellidos ?>" />
								</div>
							</div>

						</div>
					</div>

					<div class="space"></div>

					<h4 class="header blue bolder smaller">Contacto</h4>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>

						<div class="col-sm-9">
							<span class="input-icon input-icon-right">
								<input type="email" id="form-field-email" name="email" value="<?= $email ?>" />
								<i class="ace-icon fa fa-envelope"></i>
							</span>
						</div>
					</div>

					<div class="space"></div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telefono</label>

						<div class="col-sm-9">
							<span class="input-icon input-icon-right">
								<input class="input-medium input-mask-phone" type="text" name="phone" id="form-field-phone" value="<?= $phone ?>" />
								<i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
							</span>
						</div>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit" name="finalizar" value='1' >
								<i class="ace-icon fa fa-check bigger-110"></i>
								Guardar
							</button>
							&nbsp; &nbsp;
							<button class="btn" type="reset">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								Reiniciar
							</button>
						</div>
					</div>

				</div>

				<div id="edit-settings" class="tab-pane">
					<div class="space-8"></div>
					<div>
						<label class="inline">
							<input type="checkbox" name="form-field-checkbox" class="ace" />
							<span class="lbl"> Recibir notificaciones al correo</span>
						</label>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit" name="finalizar" value='2' >
								<i class="ace-icon fa fa-check bigger-110"></i>
								Save
							</button>
							&nbsp; &nbsp;
							<button class="btn" type="reset">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								Reset
							</button>
						</div>
					</div>

				</div>

				<div id="edit-password" class="tab-pane">
					<div class="space-10"></div>

					<h3>La nueva contraseña debe tener un mínimo de <?= $min_password_length?> caracteres</h3>
					&nbsp;

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">Antigua contraseña</label>
						<div class="col-sm-9">
							<input type="password" name="old" id="old"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">Nueva contraseña</label>
						<div class="col-sm-9">
							<input type="password" name="new" id="new"/>
						</div>
					</div>

					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Confirmar contraseña</label>
						<div class="col-sm-9">
							<input type="password" name="new_confirm" id="new_confirm"/>
						</div>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit" name="finalizar" value='3' >
								<i class="ace-icon fa fa-check bigger-110"></i>
								Guardar
							</button>
							&nbsp; &nbsp;
							<button class="btn" type="reset">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								Reiniciar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>