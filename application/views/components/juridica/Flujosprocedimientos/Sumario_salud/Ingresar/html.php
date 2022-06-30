<?php defined('BASEPATH') or exit('No direct script access allowed') ?>


<div>
    <div class="offset-ms-4 col-sm-6">
        <?= validation_errors() ?>
        <?php foreach ($errors as $error => $message) : ?>
            <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                <b><?= $error ?>:</b> <?= $message ?>
                <br>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">

        <div class="col-xs-12">
            <h2>Ingresar Información para Denuncia de Sumario Administrativo </h2>
            <?= form_open_multipart(site_url('Proc/SumarioSalud/insertarSumario'), 'class="form-horizontal" role="form"  method="POST"') ?>

            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fecha_solicitud">Fecha Solicitud de Denuncia:</label>
                    <input name="fecha_solicitud" data-rel="tooltip" type="date" id="fecha_solicitud" placeholder="" class="col-md-2" value="<?php echo set_value('fecha_solicitud') ?>" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">Título de denuncia:</label>
                    <input name="titulo" data-rel="tooltip" type="text" id="titulo" class="col-md-3" value="<?= set_value('titulo') ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="nom_cesfam">Nombre Cesfam Denunciante:</label>
                    <input name="nom_cesfam" data-rel="tooltip" type="text" id="nom_cesfam" placeholder="" class="col-md-2" value="<?= set_value('nom_cesfam') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label " for="rol">Código/Número Sumario Administrativo: </label>
                    <div>
                        <input name="rol" data-rel="tooltip" type="text" id="rol" placeholder="" class="col-md-2" value="<?= set_value('rol') ?>" required>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="observacion">Denuncia:</label>
                    <textarea name="observacion" maxlength="255" data-rel="tooltip" type="text" id="observacion" rows="5" placeholder="" class="col-md-6" value="<?php set_value('observacion') ?>"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="box">
                    <div class="col-md-6">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Adjuntar documentos:</h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="archivo" class="form-group" enctype="multipart/form-data">
                                        <div class="">
                                            <input multiple name="userFiles[]" type="file" id="id-input-file" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            </form>
                        </div>

                        <div class="clearfix form-actions center">
                            <button class="btn btn-info" type="submit" value="upload">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Ingresar
                            </button>
                            <a href="<?= site_url("inicio/index") ?>" class="btn btn-danger" type="reset">
                                <i class="ace-icon fa fa-times   bigger-110"></i>
                                Cancelar
                            </a>
                        </div>


                    </div>