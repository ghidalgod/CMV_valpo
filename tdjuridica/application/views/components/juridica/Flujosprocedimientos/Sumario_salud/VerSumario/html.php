<?php defined('BASEPATH') OR exit ('No direct script access allowed')?>
<div class="row">
    <div class="col-xs-12">

        
        <?php if($sumario['etapa']==0):?> <!-- aceptar o rechazar la denuncia!-->
        <h3>Inicio Procedimiento Sumario Administrativo: </h3>  
        <?= form_open_multipart(site_url('Proc/SumarioSalud/editarSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==1):?>>Instrucción Sumario
        <h3>Intrucción Sumario</h3> 
        <?= form_open_multipart(site_url('Proc/SumarioSalud/instruccionSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==2):?>
        <h3>Visación / Notificación de la resolución</h3> <!-- asignación plazos, fiscal -->
        <?= form_open_multipart(site_url('Proc/SumarioSalud/visacion/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==3):?>
        <h3>Notificación de la resolución </h3> <!-- sobreseimiento o formulación de cargos -->
        <?= form_open_multipart(site_url('Proc/SumarioSalud/dictamen/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        
        <?php if($sumario['etapa']==4):?>
        <h3>Dictamen Sumario por fiscal </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/resolucion/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==5):?>
        <h3>Procedimiento Final </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/finalizarSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

    <!--    <?php if($sumario['etapa']==6):?>
        <h3> Término Sumario </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/resolucion/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>
    -->
        <br>
      
        

        <br>
        <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fecha_solicitud">Fecha de Solicitud de la Denuncia:</label>
                    <input name="fecha_solicitud" data-rel="tooltip" type="date" id="fecha_solicitud" placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['fecha_solicitud']; ?>">
                </div>
            </div>
            <br>
        
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">Título de denuncia:</label>
                    <input name="titulo" data-rel="tooltip" type="text" id="titulo"placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?=  $sumario['titulo'] ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="nom_cesfam">Nombre Cesfam Denunciante:</label>
                    <input name="nom_cesfam" data-rel="tooltip" type="text" id="nom_cesfam"  placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?=  $sumario['nom_cesfam'] ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label " for="rol">Número Denuncia: </label>
                    <div>
                    <input name="rol" data-rel="tooltip" type="text" id="rol"  placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['rol'] ?>">

                    </div>
                </div>
            </div> 
            <br>

            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="observacion">Descripción de Denuncia:</label>
                    <textarea name="observacion" maxlength="255" data-rel="tooltip" type="text" id="observacion" rows="5" placeholder="" class="col-md-6" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['observacion'] ?>"></textarea>
                </div>
            </div>
            <br>
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
                                            <input multiple name="documento" type="file" id="id-input-file" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                                    </div>
                                </div>
                            </div>

                            <br>
            <div class="row">
                <div class="box">
                    <div class="col-md-6">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Descargar documentos </h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="documento" class="form-group">
                                        <div class="col-xs-12">
                                        <input multiple name="documento" type="file" id="id-input-filedesc"  class="form-control-file" readonly="readonly" value="<?= $sumario['archivo'];?>" />
                                            <a href="<?=site_url('Proc/SumarioSalud/download/'.$this->uri->segment(4))?>" ></a>
                                        
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
            <br>


            <?php if($sumario['etapa']== 1):?>   <!-- se notifica la resolución, pudiendo ser aceptada --sobreseimiento o rechazada--fomulación de cargos -->
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_not">Fecha Notificación Inicio de Sumario:</label>
                <input name="fecha_not" data-rel="tooltip" <?php if($sumario['etapa']==0){ echo 'readonly'; }?> type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>">
                </div>
            </div>
            <br>
                <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label " for="rut_fiscal">Rut Fiscal Asignado: </label>
                    <div>
                        <input name="rut_fiscal" data-rel="tooltip" type="text" id="rut_fiscal" placeholder="" class="col-md-2"  value="<?= $sumario['rut_fiscal']?>" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Plazo Investigación Fiscal:</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']==0){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>">
                </div>
            </div>
            <br>
            <?php endif;?>



            <?php if($sumario['etapa']== 3):?>   <!-- en la notificación de la resolución se debe escoger sobreseimiento o formulación de cargos-->
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Contador plazo etapa 3</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']===0 ||$sumario['etapa'] === 2){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>">
                </div>
            </div>

            <?php if($sumario['etapa']==3):?>
        <h1>Sobreseimiento </h1>  <!-- cierre investigación-->
        <?= form_open_multipart(site_url('Proc/SumarioSalud/sobreseimiento/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==3):?> <!-- formulación de cargos-->
        <h1>Formulación de cargos </h1>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/cargos/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>
            <?php endif;?>
            

            <?php if($sumario['etapa'] == 4):?>
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_not">DICTAMEN DEL SUMARIO POR FISCAL</label>
                <input name="fecha_not" data-rel="tooltip" <?php if($sumario['etapa']===0 ||$sumario['etapa'] === 4){ echo 'readonly'; }?> type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>">
                </div>
            </div>
            <?php endif;?>

            <?php if($sumario['etapa']== 5):?>
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_not">PROCEDIMIENTO FISCAL)</label>
                <input name="fecha_not" data-rel="tooltip" <?php if($sumario['etapa']===0 ||$sumario['etapa'] === 5){ echo 'readonly'; }?> type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>">
                </div>
            </div>
            <?php endif;?>


            <?php if($sumario['etapa']== 7):?>
            <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_res">TÉRMINO SUMARIO</label>
                <input name="fecha_not" data-rel="tooltip" <?php if($sumario['etapa']===0 ||$sumario['etapa'] === 6){ echo 'readonly'; }?> type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>">
                </div>
            </div>
            <?php endif;?>


            <br>

           <div class="clearfix form-actions center">

                <?php if($sumario['etapa'] == 0) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Estado Denuncia
                </button>
                <?php endif;?>

                <?php if($sumario['etapa'] >= 0) :?>
                <a href="<?= site_url("inicio/index")?>" class="btn btn-primary" type="reset">
                    <i class="ace-icon fa fa-times   bigger-110"></i>
                    Volver
                </a>                   
                <?php endif;?>

                <?php if($sumario['etapa'] != 0) :?>
                <button class="btn btn-info" type="submit" value="upload">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Guardar
                </button>

                <a href="<?= site_url("inicio/index")?>" class="btn btn-danger" type="reset">
                    <i class="ace-icon fa fa-times   bigger-110"></i>
                    Cancelar
                </a>
                <?php endif;?>

                <?php if($sumario['etapa'] == 2) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Resolución
                </button>
                <?php endif;?>

                
                <?php if($sumario['etapa'] == 4) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Resolución
                </button>
                <?php endif;?>
                

            <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">SUMARIO ADMINISTRATIVO:</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
            <?php if($sumario['etapa'] == 0) :?>
                <h4>Estado de la Denuncia</h4>   
            <?php endif;?>    

            <?php if($sumario['etapa'] == 2) :?>
                <h4>Notificación de la Resolución </h4>   
            <?php endif;?>  

            <?php if($sumario['etapa'] == 4) :?>
                <h4> Resolución </h4>   
            <?php endif;?>    
            </div>

            <div class="modal-footer">

            <?php if($sumario['etapa'] == 0) :?>
                <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/editarSumario/".$this->uri->segment(4).'/'.'2')?> >ACEPTADA</a> <!-- 2 es Aceptada, 1 es rechazada-->

                <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/editarSumario/".$this->uri->segment(4).'/'.'1')?> >RECHAZADA</a>
          
            <?php endif;?> 

            <?php if($sumario['etapa'] == 2) :?>
            <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/sobreseimiento/".$this->uri->segment(4).'/'.'3')?> >Sobreseimiento</a> <!-- 0 es Aceptada, 1 es rechazada-->
            <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/cargos/".$this->uri->segment(4).'/'.'4')?> >Formulación de cargos</a>
            <?php endif;?> 
<!--
            <?php if($sumario['etapa'] ==3) :?>
            <a type="button" class="btn btn-warning" href=<?= site_url("Proc/SumarioSalud/instruccionSumario/".$this->uri->segment(4).'/'.'3')?> >SOBRESEIMIENTO</a>
            <?php endif;?>  

            -->
            <?php if($sumario['etapa'] ==4) :?>
            <a type="button" class="btn btn-info" href=<?= site_url("Proc/SumarioSalud/finalizarSumario/".$this->uri->segment(4).'/'.'5')?> >ABSOLUCIÓN</a>
            
            <a type="button" class="btn btn-warning" href=<?= site_url("Proc/SumarioSalud/resolucion/".$this->uri->segment(4).'/'.'6')?> >SANCIÓN</a>
            <?php endif;?>  

            </div>
            </div>
        </div>
    </div>                
    </div>
    </div>  
</div>