<?php defined('BASEPATH') OR exit ('No direct script access allowed')?>

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
        <?= form_open_multipart(site_url('FlujoCausas/Laboral/insertar_monitorio'), 'class="form-horizontal" role="form" method="POST"') ?>


        <br>
            
            <!--Nombre del Demandante-->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">Nombre del Demandante:</label>
                    <input name="n_demandante" data-rel="tooltip" type="text" id="n_demandante" class="col-md-3" value="<?= set_value('n_demandante') ?>">
                </div>
            </div>

            <br>

            <!--Rut del demandante-->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">RUT del Demandante:</label>
                    <input name="rut" data-rel="tooltip" type="text" id="rut" class="col-md-3" value="<?= set_value('rut') ?>">
                </div>
            </div>

            <br>
    
            <!--RIT/ROL-->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="denunciante">RIT/ROL:</label>
                    <input name="rol" data-rel="tooltip" type="text" id="rol" placeholder="" class="col-md-2" value="<?=  set_value('rol') ?>">
                </div>
            </div>

            <br>

            <!--Fecha notificacion-->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fecha_not">Fecha de Notificación:</label>
                    <input name="fecha_not" data-rel="tooltip" type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?php echo set_value('fecha_not') ?>">
                </div>
            </div>

            <br>

            <!--Seleccion de tribunal-->
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="tribunal">Tribunal:</label>
                <select class="chosen-select col-md-2" name="tribunal" value="" onchange="" required>
                        <option role="placeholder" value="1">TRIBUNAL LABORAL DE VALPARAÍSO</option>
                    </select>
                </div>
            </div>

            <br>
            

            <br>

            <!--Subir archivo a carpeta local-->

            <div class="row">
                <div class="box">
                    <div class="col-md-6">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Adjuntar documento de demanda</h4>
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



            <div class="clearfix form-actions center">
                <button class="btn btn-info" type="submit" value="upload">
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
            </div>

        </form>
    </div>
    </div>  
</div>