<div class="row">
	<div class="col-xs-5">
		<div>
			<h3 class="header smaller lighter green">Estado general</h3>
			
			<div class="infobox-container">
			
				<div role="button" id="divTrabajando" class="infobox infobox-green">
					<div class="infobox-icon">
							<i class="ace-icon fa fa-street-view"></i>
					</div>
		
					<div class="infobox-data">
						<span id="numeroTrabajando" class="infobox-data-number"></span>
						<div class="infobox-content">Trabajando</div>
					</div>
				</div>
					
				<div role="button" id="divDescansando" class="infobox infobox-blue">
					<div class="infobox-icon">
						<i class="ace-icon fa fa-bed"></i>
					</div>
		
					<div class="infobox-data">
						<span id="numeroDescansando" class="infobox-data-number"></span>
						<div class="infobox-content">Descansando</div>
					</div>
				</div>
			</div>
		</div>
		
		<div>
			<h3 class="header smaller lighter purple">Con periodo anterior activo</h3>
		
			<div class="infobox-container">
			
				<div role="button" id="divAnterior" class="infobox infobox-purple">
					<div class="infobox-icon">
						<i class="ace-icon fa fa-calendar"></i>
					</div>
		
					<div class="infobox-data">
						<span id="numeroAcumulado" class="infobox-data-number"></span>
						<div class="infobox-content">Personal</div>
					</div>
				</div>
	
			</div>
		</div>
	</div>
	
	
	<div class="col-xs-7">
		<h3 class="header smaller lighter purple">
			<i class="ace-icon fa fa-signal"></i>
			Meses usados <?php echo date("Y"); ?>
		</h3>
		
		<div class="infobox-container">
			<div class="widget-box transparent">
				<div class="widget-body">
					<div class="widget-main padding-4">
						<canvas id="myChart"></canvas>
					</div><!-- /.widget-main -->
				</div><!-- /.widget-body -->
			</div><!-- /.widget-box -->
		</div><!-- /.col -->

	</div>
	
</div>
<br>

<h3 class="header smaller lighter green">Lista de Personal:</h3>
<div class="clearfix">
	<div class="pull-left">
		<span class="label label-info">Descansando</span>
		<span class="label label-warning">Termino de contrato cumplido</span>
	</div>
   <div class="pull-right tableTools-container"></div>
</div>
<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>

<?php if ($this->ion_auth->in_group(array('dlibresValidador'))): ?>

<h3 class="header smaller lighter green">Permisos solicitados:</h3>

<div>
    <table id="dynamic-table3" class="table table-striped table-bordered table-hover"></table>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="delete-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="delete-modal-label">Rechazar solicitud</h4>
            </div>
            <div class="modal-body">
				<p>Nombre: <b><span class="delete-modal-nombres"></span></b></p>
				<p>Días: <b><span class="delete-modal-dias"></span></b></p>
            </div>
            <div class="modal-footer">
        		<div class="btn-group">
        			<button type="button" data-loading-text="Cargando..." class="btn btn btn-danger loading-delete-btn" id="deleteButton">Rechazar</button>
                	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            	</div>
            </div>
        </div>
    </div>
</div>

<!-- Accept Modal -->
<div class="modal fade" id="acceptModal" role="dialog" aria-labelledby="accept-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="accept-modal-label">Aceptar solicitud</h4>
            </div>
            <div class="modal-body">
				<p>Nombre: <b><span class="accept-modal-nombres"></span></b></p>
				<p>Días: <b><span class="accept-modal-dias"></span></b></p>
            </div>
            <div class="modal-footer">
        		<div class="btn-group">
        			<button type="button" data-loading-text="Cargando..." class="btn btn btn-success loading-accept-btn" id="acceptButton">Aceptar</button>
                	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            	</div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<!-- Modal agregar Feriado legal -->
<div class="modal fade" id="addModalFL" role="dialog">
    <div class="modal-dialog"> <!-- <div class="modal-dialog modal-lg"> -->
        <div class="modal-content">

            <div id="ERROR_FORM_VALIDATOR" class="alert alert-danger" >
                <strong>
                    <i class="ace-icon fa fa-times"></i>
                    Complete los campos enmarcados en rojo
                </strong>
            </div>
            <div id="ERROR_SYSTEM" class="alert alert-danger" >
                <strong>
                    <i class="ace-icon fa fa-times"></i>
                    <span id="TEXT_ERROR_SYSTEM"> </span>
                </strong>
            </div>
            <div id='ERROR_SAVE_DB'></div>
            
                
			<?= form_open_multipart(NULL, 'id="formFL" role="form" class="form-horizontal"' ); ?>
	            <div class="modal-body">
	            	<h3 class="header smaller lighter green">
						<i class="ace-icon fa fa-plane"></i>
							Feriado legal
					</h3>
					
					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> Nombre: </div>

							<div class="profile-info-value">
								<span id="nombre"> Cargando...</span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> RUN: </div>

							<div class="profile-info-value">
								<span id="run"> Cargando... </span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Disponibles: </div>

							<div class="profile-info-value">
								<span id="dias"> Cargando... </span>
							</div>
						</div>
					</div>
					
					<div class="space-12"></div>
					
		            <div class="row">
		            	<div id="diasForm" class="form-group col-xs-9">
		            		<div class="row">
		            			<label class="col-md-3 control-label" for="inicio">Inicio: </label>
			            		<div class="input-group col-md-6">
									<input class="form-control date-picker" id="dataInicio" name="inicio" type="date"/>
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
		            		</div>
		            		
		            		<div class="row">
			            		<label class="col-md-3 control-label" for="termino">Termino: </label>
								<div class="input-group col-md-6">
									<input class="form-control date-picker" id="dataTermino" name="termino" type="date"/>
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
		            	</div>
		            	
		            	<div  class="form-group col-xs-3">
		            		<div class="btn btn-app btn-sm btn-success" id="contarDias" role="button">
								<div class="row line-height-1">
									<span class="line-height-1 bigger-110" id="contarDiasText"> </span>
									<i id="skinerOn" class="ace-icon fa fa-spinner fa-spin orange bigger-110" style="display:none"></i>
									<br />
									<br />
									<span class="line-height-1 smaller-80"> Calcular Días </span>
								</div>
							</div>
		            	</div>
		            	
		            </div>
		            <!-- Nuevo -->
					<div class="row form-group col-xs-12">
	            		<div class="checkbox">
							<label>
								<input name="finDeSemana" type="checkbox" class="ace" />
								<span class="lbl"> Descontar fin de semana</span>
							</label>
						</div>
					</div>
					<div class="space-12"></div>
					<!-- Nuevo -->
		            
		            <div class="row">
		            	<div class="col-md-12">
							<div class="widget-box">
								<div class="widget-header">
									<h4 class="widget-title">Adjuntar solicitud</h4>
								</div>
						
								<div class="widget-body">
									<div class="widget-main">
										<div id="documento" class="form-group">
											<div class="col-xs-12">
												<input name="documento" type="file" id="id-input-file" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
		            </div>

				</div>
				
				<div class="modal-footer">

	                <button id='submitButton' type="submit" class="btn btn-sm btn-primary">
	                		<i id="skinerOnRegister" class="ace-icon fa fa-spinner fa-spin orange bigger-110" style="display:none"></i>
	                        <i class="ace-icon fa fa-check"></i>
	                        Registrar
	                </button>
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
	            </div> <!-- Modal Footer -->
            </form>
        </div>
    </div>
</div>

<!-- Modal agregar Dia Administrativo -->
<div class="modal fade" id="addModalDA" role="dialog">
    <div class="modal-dialog"> <!-- <div class="modal-dialog modal-lg"> -->
        <div class="modal-content">
      
            <div id="ERROR_FORM_VALIDATOR_DA" class="alert alert-danger" >
                <strong>
                    <i class="ace-icon fa fa-times"></i>
                    Complete los campos enmarcados en rojo
                </strong>
            </div>
            <div id="ERROR_SYSTEM_DA" class="alert alert-danger" >
                <strong>
                    <i class="ace-icon fa fa-times"></i>
                    <span id="TEXT_ERROR_SYSTEM_DA"> </span>
                </strong>
            </div>
            <div id='ERROR_SAVE_DB_DA'></div>
            
			<?= form_open_multipart(NULL, 'id="formDA" role="form" class="form-horizontal"' ); ?>
	            <div class="modal-body">
	            	<h3 class="header smaller lighter green">
						<i class="ace-icon fa fa-plane"></i>
							Día administrativo
					</h3>
					
					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> Nombre: </div>

							<div class="profile-info-value">
								<span id="nombre"> Cargando...</span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> RUN: </div>

							<div class="profile-info-value">
								<span id="run"> Cargando... </span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Disponibles: </div>

							<div class="profile-info-value">
								<span id="dias"> Cargando... </span>
							</div>
						</div>
					</div>
					
					<div class="space-12"></div>
					
					<div class="row">
						<div id="diasForm_da" class="row form-group col-xs-12">
	            		<label class="col-md-3 control-label" for="dias">Días a solicitar: </label>
	            		<select class="col-md-9" name="dias" data-placeholder="1 o medio día">
	            			<option value="">  </option>
	            			<option value="1"> 1 </option>
	            			<option value="0.5"> 1/2 </option>
						</select>
	            	</div>
	            	</div>
	            	
		            <div class="row">
		            	<div id="inicioForm_da" class="row form-group col-xs-12">
		            		<label class="col-md-3 control-label" for="inicio_da">Inicio: </label>
		            		<div class="input-group col-md-3">
								<input class="form-control date-picker" id="inicio_da" name="inicio_da" type="date"/>
								<span class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
							</div>
		            	</div>
		            	
		            	<div class="col-md-12">
							<div class="widget-box">
								<div class="widget-header">
									<h4 class="widget-title">Adjuntar solicitud</h4>
								</div>
						
								<div class="widget-body">
									<div class="widget-main">
										<div id="documento_da" class="form-group">
											<div class="col-xs-12">
												<input name="documento" type="file" id="id-input-file_da" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
		            </div>	

				</div>
				
				<div class="modal-footer">
	                <button type="submit" class="btn btn-sm btn-primary">
	                		<i id="skinerOnRegister2" class="ace-icon fa fa-spinner fa-spin orange bigger-110" style="display:none"></i>
	                        <i class="ace-icon fa fa-check"></i>
	                        Registrar
	                </button>
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
	            </div> <!-- Modal Footer -->
            </form>
        </div>
    </div>
</div>