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
		<?= form_open(site_url('anexos/editold/'. $this->uri->segment(3)), 'class="form-horizontal" role="form"') ?>
        	<h3 class="header smaller lighter green">Datos del anexo</h3>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="nombre">Nombre: </label>
                <div class="col-sm-8">
                	<input id="nombre" name="nombre" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= $nombre ?>">
                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Nombre del usuario con anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="anexo">Anexo: </label>
                <div class="col-sm-8">
                    <input id="anexo" name="anexo" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= $anexo ?>">
                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Número de anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="cargo">Cargo: </label>
                <div class="col-sm-8">
                    <input id="cargo" name="cargo" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= $cargo ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="departamento">Departamento o dirección: </label>
                <div class="col-sm-8">
                    <input name="departamento" data-rel="tooltip" type="text" id="departamento" class="col-xs-10 col-sm-6" value="<?= $departamento ?>">
                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Departamento o dirección a la que pertenece el anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="email">Email: </label>
                <div class="col-sm-8">
                    <input id="email" name="email" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= $email ?>">
                </div>
            </div>

            <div class="clearfix form-actions center">
                <button class="btn btn-info" type="submit" name="finalizar">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Finalizar
                </button>
                <a href="<?= site_url("anexos/index")?>" class="btn btn-danger" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>  
</div>