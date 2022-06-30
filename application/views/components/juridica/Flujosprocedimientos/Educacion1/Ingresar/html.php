

<div class="row linea-separadora">
    <div class="col-lg-12">
        <hr size="8px" color="black" />
    </div>
</div>

<div>
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
        <h1>Ingresar información de Denuncia </h1>
        <?= form_open_multipart(site_url('Proc/Educacion1/IngresarProc1'), 'class="form-horizontal" role="form"') ?>

            <br>
            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">Título de denuncia:</label>
                    <input name="titulo" data-rel="tooltip" type="text" id="titulo" class="col-md-3" value="<?= set_value('titulo') ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="denunciante">Nombre denunciante:</label>
                    <input name="denunciante" data-rel="tooltip" type="text" id="denunciante" placeholder="" class="col-md-2" value="<?=  set_value('denunciante') ?>">
                </div>
            </div>
  <!--          <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="RUC">RUC:</label>
                    <input name="RUC" data-rel="tooltip" type="text" id="RUC" placeholder="" class="col-md-2" value="<?php echo set_value('RUC') ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="asignar">Asignar a: </label>
                    <select class="chosen-select col-md-2" name="asignado" value="" onchange="var opt=this.options[0];if(opt.getAttribute('role')==='placeholder'&&!opt.selected)opt.parentNode.removeChild(opt);">
                        <option role="placeholder" value=""> Seleccionar Usuario</option>
                    <?php foreach( $usuarios as $key => $value): ?>
                        <option value="<?php echo $value ?>" > <?php echo $value ?> </option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div> -->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="denuncia">Denuncia:</label>
                    <textarea name="denuncia" maxlength="255" data-rel="tooltip" type="text" id="denuncia" rows="5" placeholder="" class="col-md-6" value="<?php echo set_value('denuncia')?>"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label " for="tipo">Tipo: </label>
                    <div>
                        <input name="tipo" data-rel="tooltip" type="radio" id="tipo"  class="col-md-1" value="<?php echo ('tipo'=='1')?'checked':'' ?>">Interno</input>
                    </div>
                    <div>
                        <input name="tipo" data-rel="tooltip" type="radio" id="tipo"  class="col-md-1" value="<?php echo ('tipo'=='2')?'checked':'' ?>">Externo</input>

                    </div>
                </div>
            </div>

            <div class="clearfix form-actions center">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Ingresar
                </button>
                <a href="<?= site_url("inicio/index")?>" class="btn btn-danger" type="reset">
                    <i class="ace-icon fa fa-times   bigger-110"></i>
                    Cancelar
                </a>
            </div>

        </form>
    </div>  
</div>
