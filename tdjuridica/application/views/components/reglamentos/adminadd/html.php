<div class="offset-ms-4 col-sm-6">
    <?= validation_errors() ?>
    <?php foreach($errors as $error => $message): ?>
        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <b><?= $error ?>:</b> <?= $message ?>
        <br></div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-xs-12">
		<?= form_open(site_url('reglamentos/addnew'), 'class="form-horizontal" role="form"') ?>
        	<h3 class="header smaller lighter green">Información del archivo</h3>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="nombre">Nombre del documento: </label>
                <div class="col-sm-8">
                    <input name="nombre" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('nombre') ?>">
                    <span data-html="true" class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="El nombre del archivo <strong>debe</strong> incluir la extensión del mismo (.pdf, .docx, .ppt)" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="tipo">Tipo: </label>
                <div class="col-sm-8">
                    <input name="tipo" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('tipo') ?>">
                    <span data-html="true" class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Si no esta seguro de que a que sección debería corresponder, escriba 'Otros'" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="descripcion">Descripción: </label>
                <div class="col-sm-8">
                    <textarea name="descripcion" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('descripcion') ?>"></textarea>
                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Descripción del uso o propósito del archivo" title="Condiciones" data-original-title="Condiciones">?</span>
                </div>
            </div>
			
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="codigo">Código*: </label>
                <div class="col-sm-8">
                    <input name="codigo" data-rel="tooltip" type="text" id="departamento" class="col-xs-10 col-sm-6" value="<?= set_value('codigo') ?>">
                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Tutorial para obtener el código, abajo de este formulario" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>
            
            <div class="clearfix form-actions center">
                <a href="<?= site_url("reglamentos/index")?>" class="btn btn-danger" type="reset">
                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                    Cancelar
                </a>
                <button class="btn btn-info" type="submit" name="finalizar">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Finalizar
                </button>
            </div>
            
            <h3 class="header smaller lighter green">Obtención del código*</h3>

			<div id="accordion" class="accordion-style1 panel-group">
		    
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
								<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp; 1) El documento debe existir en las carpetas del drive de transformacion digital.
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="collapseOne">
						<div class="panel-body">
	            			<img src="<?= base_url('files/tutoreg1.png') ?>" alt="carpetas del drive" border="0" >
						</div>
					</div>
				</div>
	
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
								<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp; 2) Hay que dar click derecho en el archivo deseado, luego seleccionar "compartir" y la opción "quien tiene acceso".
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="collapseTwo">
						<div class="panel-body">
							<img src="<?= base_url('files/tutoreg2.png') ?>" alt="compartir" border="0" width="30%" height="30%" hspace="60">
							<img src="<?= base_url('files/tutoreg3.png') ?>" alt="quién tiene acceso" border="0" width="40%" height="40%">
						</div>
					</div>
				</div>
	
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
								<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp; 3) Seleccionar la opción "Compartir mediante enlace" y activarlo. Al hacerlo, esto nos presentará un link a copiar.
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="collapseThree">
						<div class="panel-body">
	                        <img src="<?= base_url('files/tutoreg4.png') ?>" alt="compartir mediante enlace" border="0" width="40%" height="40%" hspace="60">
	            			<img src="<?= base_url('files/tutoreg5.png') ?>" alt="copiar en portapeles" border="0" width="40%" height="40%">
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
								<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp; 4) El código deseado se encuentra en este link copiado, señalado por la sección en rojo a continuación.
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="collapseFour">
						<div class="panel-body">
	                        <img src="<?= base_url('files/tutoreg6.png') ?>" alt="código" border="0">
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
								<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp; 5) Finalmente, copiar la sección en rojo del link y pegar en el campo que solicita este formulario.
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="collapseFive">
						<div class="panel-body">
	                        <img src="<?= base_url('files/tutoreg7.png') ?>" alt="código" border="0">
						</div>
					</div>
				</div>
			</div>
        </form>
    </div>  
</div>