<h3 class="header smaller lighter green"><?= $persona['nombres'] .' '. $persona['apellido_paterno'].' '. $persona['apellido_materno'] ?></h3>
<div id="infoMessage"><?php echo $message;?></div>
<div class="row">
	
	<div class="col-sm-4">
    	<div class="widget-box">
        	<div class="widget-header widget-header-flat">
        		<h4 class="widget-title">Información general</h4>
    		</div>
    		<div class="widget-body">
        		<div class="widget-main">
        			<div class="row">
        				<div class="col-sm-12">
    						<ul>
			        		    <li>
					        	    <b>Nombre: </b> <?= $persona['nombres'] .' '. $persona['apellido_paterno'].' '. $persona['apellido_materno'] ?>
    						    </li>
    						    <li>
					        	    <b>RUT: </b> <?= $persona['rut'] .'-'. $persona['digito_rut'] ?>
    						    </li>
    						    <li>
					        	    <b>Total FL: </b> <?= $persona['feriados_legales'] ?>
    						    </li>
    						    <li>
					        	    <b>Días Administrativos: </b> <?= $persona['dias_libres'] ?>
    						    </li>
    						    <li>
					        	    <b>PSGS: </b> <?= $persona['psgs'] ?>
    						    </li>
    						    <li>
					        	    <b>Centro: </b> <?= $persona['centro'] ?>
    						    </li>
    					    </ul>
    				    </div>
    			    </div>
    		    </div>
		    </div>
	    </div>
	</div>
	
	<div class="col-sm-4">
    	<div class="widget-box">
        	<div class="widget-header widget-header-flat">
        		<h4 class="widget-title">Información feriados legales</h4>
    		</div>
    		<div class="widget-body">
        		<div class="widget-main">
        			<div class="row">
        				<div class="col-sm-12">
    						<ul>
			        		    <li>
					        	    <b>Disponible <?php echo date('Y'); ?>: </b> <?= $persona['periodo_actual'] ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados <?php echo date('Y'); ?>: </b> <?= $persona['usados_actual'] ?>
    						    </li>
    						    <li>
					        	    <b>Disponible <?php echo (int)date('Y') - 1; ?>: </b> <?= $persona['periodo_anterior'] ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados <?php echo (int)date('Y') - 1; ?>: </b> <?= $persona['usados_anterior'] ?>
    						    </li>
    						    <?php
    						    	if($persona['periodos_adicionales'] != false){
    						    		foreach($persona['periodos_adicionales'] as $key => $value){
    						    			echo '<li><b>Disponible ' . $value->año . ':</b> ' . $value->disponible . '&nbsp;&nbsp;&nbsp;&nbsp;<b>Utilizados ' . $value->año . ':</b> ' . ($value->total - $value->disponible)  . '</li>';
    						    			
    						    		}
    						    	}
    						    
    						    ?>
    					    </ul>
    				    </div>
    			    </div>
    		    </div>
		    </div>
	    </div>
	</div>
	
	<div class="col-sm-4">
    	<div class="widget-box">
        	<div class="widget-header widget-header-flat">
        		<h4 class="widget-title">Información de cargo</h4>
    		</div>
    		<div class="widget-body">
        		<div class="widget-main">
        			<div class="row">
        				<div class="col-sm-12">
    						<ul>
			        		    <li>
					        	    <b>Cargo: </b> </b> <?= $persona['cargo'] ?>
    						    </li>
    						    <li>
					        	    <b>Categoria: </b> </b> <?= $persona['categoria'] ?>
    						    </li>
    						    <li>
					        	    <b>Nivel: </b> </b> <?= $persona['nivel'] ?>
    						    </li>
    						    <li>
					        	    <b>Fecha reconocimiento: </b> </b> <?= $persona['reconosimiento'] ?>
    						    </li>
    					    </ul>
    				    </div>
    			    </div>
    		    </div>
		    </div>
	    </div>
	</div>
	
</div>

<h3 class="header smaller lighter green">Días administrativos y feriados</h3>

<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>

<h3 class="header smaller lighter green">Formularios de registro</h3>
<div class="row center">
	<?php if($submit == 0): ?>
	<div class="offset-ms-4 col-sm-4">
	</div>
	<?php endif; ?>
	<?php if($submit == 2): ?>
	<div class="offset-ms-4 col-sm-8">
	</div>
	<?php endif; ?>
	<div class="offset-ms-4 col-sm-4">
	    <?= validation_errors() ?>
	    <?php foreach($errors as $error => $message): ?>
	        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
	        <b><?= $error ?>:</b> <?= $message ?>
	        <br></div>
	    <?php endforeach; ?>
	</div>	
</div>

<div id="inicioFormId" class="row">
	
	<div class="col-sm-4">
		<?= form_open_multipart(site_url('DiasLibres/persona/'. $rut), 'id="formFL" role="form" class="form-horizontal"' ); ?>
	    	<div class="widget-box">
	        	<div class="widget-header widget-header-flat">
	        		<h4 class="widget-title">Feriado legal</h4>
	    		</div>
	    		<div class="widget-body">
	        		<div class="widget-main">
	        			
	        			<div class="row">
        					<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Disponibles: </div>
									<div class="profile-info-value">
										<?= $persona['feriados_legales'] ?>
									</div>
								</div>
							</div>
	        			</div>
	        			<h4 class="header smaller lighter green">Información:</h4>
	        			<div class="row">
	        				<div class="col-sm-7">
	        					<div class="row">
			            			<label class="col-md-3 control-label" for="inicio">Inicio: </label>
				            		<div class="input-group col-md-6">
										<input class="form-control date-picker" id="dataInicio" name="inicio" type="date" value="<?php echo set_value('inicio'); ?>" />
										<span class="input-group-addon">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
			            		</div>
			            		<div class="row">
				            		<label class="col-md-3 control-label" for="termino">Termino: </label>
									<div class="input-group col-md-6">
										<input class="form-control date-picker" id="dataTermino" name="termino" type="date" value="<?php echo set_value('termino'); ?>" />
										<span class="input-group-addon">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
	    				    </div>
	    				    <div class="col-sm-4">
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
	    			    <br>
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
													<input name="documento_fl" type="file" id="id-input-file_fl" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
			            </div>
			            <br>
			            <div class="row center">
			            	<button type="submit" class="btn btn-sm btn-primary" value="1" name="submit">
		                        <i class="ace-icon fa fa-check"></i>
		                        Registrar
		                	</button>
			            </div>
	    			    
	    		    </div>
			    </div>
		    </div>
		</form>
	</div>
	
	<div class="col-sm-4">
		<?= form_open_multipart(site_url('DiasLibres/persona/'. $rut), 'id="formFL" role="form" class="form-horizontal"' ); ?>
	    	<div class="widget-box">
	        	<div class="widget-header widget-header-flat">
	        		<h4 class="widget-title">Día Administrativo</h4>
	    		</div>
	    		<div class="widget-body">
	        		<div class="widget-main">
	        			
	        			<div class="row">
        					<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Disponibles: </div>
									<div class="profile-info-value">
										<?= $persona['dias_libres'] ?>
									</div>
								</div>
							</div>
	        			</div>
	        			
	        			<h4 class="header smaller lighter green">Información:</h4>
	        			
	        			<div class="row">
	        				
	        				<div class="row form-group col-md-12">
			            		<label class="col-md-3 control-label" for="dias">Días a solicitar: </label>
			            		<select class="col-md-4" name="dias">
			            			<option value="" >  </option>
			            			<option value="1" <?= $dias == 1 ? 'selected' : ''; ?> > 1 </option>
			            			<option value="0.5" <?= $dias == 0.5 ? 'selected': ''; ?> > 1/2 </option>
								</select>
			            	</div>
			            	<div class="row form-group col-md-12">
			            		<label class="col-md-3 control-label" for="inicio_da">Inicio: </label>
			            		<div class="input-group col-md-3">
									<input class="form-control date-picker" id="inicio_da" name="inicio_da" type="date" value="<?php echo set_value('inicio_da'); ?>" />
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
			            	</div>
	        			</div>
	        			
	        			<div class="row">
			            	<div class="col-md-12">
								<div class="widget-box">
									<div class="widget-header">
										<h4 class="widget-title">Adjuntar solicitud</h4>
									</div>
									<div class="widget-body">
										<div class="widget-main">
											<div id="documento_da" class="form-group">
												<div class="col-xs-12">
													<input name="documento_da" type="file" id="id-input-file_da" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
			            <div class="row center">
			            	<button type="submit" class="btn btn-sm btn-primary" value="0" name="submit">
		                        <i class="ace-icon fa fa-check"></i>
		                        Registrar
		                	</button>
			            </div>
	    		    </div>
			    </div>
		    </div>
		</form>
	</div>
	
    
	<div class="col-sm-4">
	    <?php /*
		<?= form_open_multipart(site_url('DiasLibres/persona/'. $rut), 'id="formFL" role="form" class="form-horizontal"' ); ?>
	    	<div class="widget-box">
	        	<div class="widget-header widget-header-flat">
	        		<h4 class="widget-title">Permisos adicionales</h4>
	    		</div>
	    		<div class="widget-body">
	        		<div class="widget-main">
	        			
	        			<div class="row">
        					<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Disponibles psgs: </div>
									<div class="profile-info-value">
										<?= $persona['psgs'] ?>
									</div>
								</div>
							</div>
	        			</div>
	        			
	        			<h4 class="header smaller lighter green">Información:</h4>
	        			
	        			<div class="row">
	        				
	        				<div class="row form-group col-md-12">
			            		<label class="col-md-3 control-label" for="tipo">Tipo: </label>
			            		<select class="col-md-7" name="tipo">
			            			<option value="" >  </option>
			            			<option value="1" <?= $tipo == 1 ? 'selected' : ''; ?> > Permiso sin goce de sueldo </option>
			            			<option value="2" <?= $tipo == 2 ? 'selected': ''; ?> > Beca</option>
								</select>
			            	</div>
			            	
	        				
			            	<div class="row form-group col-md-12">
			            			<label class="col-md-3 control-label" for="inicio_otros">Inicio: </label>
				            		<div class="input-group col-md-6">
										<input class="form-control date-picker" name="inicio_otros" type="date" value="<?php echo set_value('inicio_otros'); ?>" />
										<span class="input-group-addon">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
			            		</div>
			            		<div class="row form-group col-md-12">
				            		<label class="col-md-3 control-label" for="termino_otros">Termino: </label>
									<div class="input-group col-md-6">
										<input class="form-control date-picker" name="termino_otros" type="date" value="<?php echo set_value('termino_otros'); ?>" />
										<span class="input-group-addon">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
	    				    </div>
	    				    
	        			<div class="row">
			            	<div class="col-md-12">
								<div class="widget-box">
									<div class="widget-header">
										<h4 class="widget-title">Adjuntar solicitud</h4>
									</div>
									<div class="widget-body">
										<div class="widget-main">
											<div id="documento_otros" class="form-group">
												<div class="col-xs-12">
													<input name="documento_otros" type="file" id="id-input-file_otros" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
			            <div class="row center">
			            	<button type="submit" class="btn btn-sm btn-primary" name="submit" value="2">
		                        <i class="ace-icon fa fa-check"></i>
		                        Registrar
		                	</button>
			            </div>
	    		    </div>
			    </div>
		    </div>
		</form>
		*/ ?>
	</div>

</div>