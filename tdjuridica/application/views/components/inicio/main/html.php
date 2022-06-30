<?php if (!$this->ion_auth->in_group(array(22, 23))) : ?>
	<!--Si pertenece a juridica, devuelve falso y no entra al if -->

	<div class="row">
		<div class="col-md-6">
			<div class="widget-box">
				<div class="widget-header widget-header-flat">
					<h4 class="widget-title">CESFAM/SAPU (<?= $resumen['centros'] ?>)</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">

						<div class="row center">
							<p class="alert alert-info col-md-8">
								Funcionarios Activos
							</p>
							<p class="alert alert-info col-md-4">
								<?= $resumen['activos'] ?>
							</p>
						</div>

						<div class="row center">
							<div class="clearfix col-md-6">
								<div class="grid2">
									<h4> Presentes </h4>
									<span class="bigger-300 blue"><?= $resumen['precentes'] ?></span>
								</div>

								<div class="grid2">
									<h4> Ausentes </h4>
									<span class="bigger-300 blue"><?= $resumen['ausentes'] ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="profile-user-info profile-user-info-striped">
									<div class="profile-info-row">
										<div class="profile-info-name"> Feriados L. </div>
										<div class="profile-info-value">
											<span><?= $resumen['feriados'] ?></span>
										</div>
									</div>
									<div class="profile-info-row">
										<div class="profile-info-name"> Administrativo </div>
										<div class="profile-info-value">
											<span><?= $resumen['administrativos'] ?></span>
										</div>
									</div>
									<div class="profile-info-row">
										<div class="profile-info-name"> Licencias </div>
										<div class="profile-info-value">
											<span><?= $resumen['licencias'] ?></span>
										</div>
									</div>
									<div class="profile-info-row">
										<div class="profile-info-name"> Otros permisos </div>
										<div class="profile-info-value">
											<span><?= $resumen['otros'] ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row">
							<table class="table table-bordered table-striped">

								<tbody>
									<tr>
										<td>Funcionarios Planta</td>

										<td>
											<b class="blue"><?= $resumen['plantas'] ?></b>
										</td>

									</tr>

									<tr>
										<td>Funcionario Contrato</td>

										<td>
											<b class="blue"><?= $resumen['contratos'] ?></b>
										</td>

									</tr>

									<tr>
										<td>Funcionarios Reemplazo</td>

										<td>
											<b class="blue"><?= $resumen['reemplazos'] ?></b>
										</td>

									</tr>

								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div><!-- /.col -->

		<div class="col-sm-6">
			<div class="tabbable">
				<ul class="nav nav-tabs" id="myTab">

					<li class="active">
						<a data-toggle="tab" href="#fechas">
							<i class="blue ace-icon fa fa-plane bigger-120"></i>
							Feriados
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#noticias">
							<i class="ace-icon fa fa-info bigger-120"></i>
							Noticias
						</a>
					</li>


				</ul>

				<div class="tab-content">
					<div id="noticias" class="tab-pane fade">
						<?= $noticias ?>
					</div>
					<div id="fechas" class="tab-pane fade in active">
						<div class="table-responsive table table-bordered table-hover table-wrapper">
							<table class="table"><?php echo $tabla ?></table>
						</div>
					</div>

				</div>
			</div>
		</div><!-- /.col -->
	</div>

<?php endif; ?>

<div class="clearfix center col-xs-12">
</div>
	<!---------------------------------------FLUJOS  CAUSAS------------------------------------------------------------------>
	
<?php if ($this->ion_auth->in_group(array(22, 23))) : ?>

	<div class="clearfix center col-xs-12"></div>

	<h3>Flujo de Causas</h3>

	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>

			<div>
				<table id="dynamic-table1" class="display" style="width:100%"></table>
			</div>

		</div>
	</div>


	<!--MODAL-------------------------------------------------------------------------------------------------->

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLabel">Notificación enviada</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>El correo ha sido enviado.</p>
				</div>

				<div class="modal-footer">
					<button id="asignar" type="submit" class="btn btn-primary">Cerrar</button>
				</div>
			</div>
			</form>
		</div>
	</div>

	<?php endif; ?>
	<!--------------------------------------------------------------------------------------------------------->

	<!---------------------------------------FLUJOS PROCEDIMIENTOS------------------------------------------------------------------>
	
<div class="clearfix center col-xs-12">
</div>

<?php if ($this->ion_auth->in_group(array(22, 23))) : ?>

	<div class="clearfix center col-xs-12"></div>

	<h3>Flujo de Procedimientos</h3>
	<h4>Sumario Administrativo Atención Primaria de Salud</h4>

	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>


			<div>
			<table id="dynamic-table" class="display" style="width:100%"></table>
			</div>

		</div>
	</div>


	<!--MODAL-------------------------------------------------------------------------------------------------->

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="sumarioTabla">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLabel">Notificación enviada</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>El correo ha sido enviado.</p>
				</div>

				<div class="modal-footer">
					<button id="asignar" type="submit" class="btn btn-primary">Cerrar</button>
				</div>
			</div>
			</form>
		</div>
	</div>


	<!--------------------------------------------------------------------------------------------------------->

<?php endif; ?>

<h3 class="header smaller lighter green">Sistemas externos</h3>
<div class='parent grid-parent'>
	<div id="Link" class="contenedor child">
		<a href="https://accounts.google.com/signin/v2/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&service=mail&sacu=1&rip=1&flowName=GlifWebSignIn&flowEntry=ServiceLogin" title="Gmail" target="_blank">
			<div class="cuadro dos">
				<img src="<?= base_url('files/logo3.png') ?>" alt="Gmail" border="0">
				<label>Gmail</label>
			</div>
		</a>
	</div>
	<div id="Link" class="contenedor child">
		<a href="https://enterprise3.processmaker.com/syscmvalparaiso/es/neoclassic/login/login" title="ProcessMaker" target="_blank">
			<div class="cuadro uno">
				<img src="<?= base_url('files/logo2.png') ?>" alt="Proces" border="0">
				<label>Process <p>Maker</p></label>
			</div>
		</a>
	</div>
	<div id="Link" class="contenedor child">
		<a href="https://soporte.cmvalparaiso.cl/" title="SoporteCMV" target="_blank">
			<div class="cuadro tres">
				<img src="<?= base_url('files/logo4.png') ?>" alt="soporte" border="0">
				<label>Plataforma <p>de soporte</p></label>
			</div>
		</a>
	</div>
	<div id="Link" class="contenedor child">
		<a href="https://cmvalparaiso.cl/" title="Corporación Municipal de Valparaíso" target="_blank">
			<div class="cuadro cuatro">
				<img src="<?= base_url('files/logo.png') ?>" alt="Corpo" border="0">
				<label>
					<p>Corporación Municipal de Valparaíso</p>
				</label>
			</div>
		</a>
	</div>
</div>