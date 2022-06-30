<?php defined('BASEPATH') OR exit ('No direct script access allowed')?>
<div class="row">
    <div class="col-xs-12">

        
        <?php if($sumario['etapa']==0):?> <!-- aceptar o rechazar la denuncia!-->
        <h3>Inicio Procedimiento Sumario Administrativo: </h3>  
        <?= form_open_multipart(site_url('Proc/SumarioSalud/editarSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==1):?> <!-- asignación plazos, fiscal -->
        <h3>Instrucción Sumario</h3> 
        <?= form_open_multipart(site_url('Proc/SumarioSalud/instruccionSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==2):?>  <!-- sobreseimiento o formulación de cargos -->
        <h3>Visación / Notificación de la resolución</h3> 
        <?= form_open_multipart(site_url('Proc/SumarioSalud/visacion/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        
        <?php if($sumario['etapa']==3):?>
        <h3>Notificación de la resolución </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/cargos/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==4):?>
        <h3> Sobreseimiento </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/sobreseimiento/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==5):?>
        <h3> Formulación de Cargos </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/dictamen/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==6):?>
        <h3> Formulación de Cargos/ Prórroga Plazo de Investigación </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/fechasSumario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>
     

        <?php if($sumario['etapa']==7):?>
        <h3>Dictamen Sumario por fiscal </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/dictamenFiscal/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==8):?>
        <h3>absolucion FISCAL </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/absolucion/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==9):?>
        <h3>Resolución por Fiscal/Elevar antecedentes </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/antecedentes/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>
    
        <?php if($sumario['etapa']==10):?>
        <h3>Dictamen Secretario General </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/resolucionSecretario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==11):?>
        <h3>Dictamen Secretario General </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/resolucionSecretario/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>

        <?php if($sumario['etapa']==12):?>
        <h3>Dictamen Final Secretario General </h3>
        <?= form_open_multipart(site_url('Proc/SumarioSalud/valorMulta/'. $this->uri->segment(4)), 'class="form-horizontal" role="form" method="POST"') ?>
        <?php endif;?>
    
        <br>
      
        

        <br>
        <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fecha_solicitud">Fecha de Solicitud de Sumario:</label>
                    <input name="fecha_solicitud" data-rel="tooltip" type="date" id="fecha_solicitud" placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['fecha_solicitud']; ?>">
                </div>
            </div>
            <br>
        
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="titulo">Título de Sumario Administrativo:</label>
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
                    <label class="col-md-2 control-label " for="rol">Número Sumario Administrativo: </label>
                    <div>
                    <input name="rol" data-rel="tooltip" type="text" id="rol"  placeholder="" readonly="readonly" class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['rol'] ?>">

                    </div>
                </div>
            </div> 
            <br>

            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="observacion">Descripción de Sumario:</label>
                    <input name="observacion" maxlength="255" data-rel="tooltip" type="text" id="observacion"  style='width:20cm' class="col-md-2" <?php if($sumario['etapa']>=0){ echo 'readonly'; }?> value="<?= $sumario['observacion'] ?>">
                </div>
            </div>
            <br>

<!-- se notifica la resolución, pudiendo ser aceptada --sobreseimiento o rechazada--fomulación de cargos -->        
            <?php if($sumario['etapa']== 1 && $sumario['sentencia']== 2):?> 
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
            <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_not">Fecha Notificación Inicio de Sumario:</label>
                <input name="fecha_not" data-rel="tooltip" type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>" required>
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
                <input name="plazo_fiscal" data-rel="tooltip"  type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>" required>
                </div>
                </div>

            <?php endif;?>

<!-- VISACIÓN-->
            <?php if($sumario['etapa']== 2):?>   <!-- en la notificación de la resolución se debe escoger sobreseimiento o formulación de cargos-->

            
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Plazo Investigación Fiscal:</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']==2){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>" required>
                </div>
                </div>
               
            <?php endif;?> 

<!-- SOBRESEIMIENTO -->
            <?php if($sumario['etapa']== 4 && $sumario['sentencia'] == 3):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Plazo Investigación Fiscal:</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']== 4 && $sumario['sentencia'] == 3){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>">
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sob">Nuevo Plazo Investigación Fiscal:</label>
                <input name="fecha_sob" data-rel="tooltip"  type="date" id="fecha_sob" placeholder="" class="col-md-2" value="<?= $sumario['fecha_sob']?>">
                </div>
                </div>
                <br>
                
            <?php endif;?>
      
<!--Inicio Sumario /FORMULACIÓN DE CARGOS -->

            <?php if($sumario['etapa'] == 5):?>  
                <br>
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
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Plazo Investigación Fiscal:</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']==5){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>">
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_not">Fecha Notificación Inicio de Sumario:</label>
                <input name="fecha_not" data-rel="tooltip"  <?php if($sumario['etapa']==5){ echo 'readonly'; }?> type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>" required>
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_plazos">Fecha Notificación de los Cargos:</label> <!-- fecha notificación de los cargos al inculpado -->
                <input name="fecha_plazos" data-rel="tooltip"  type="date" id="fecha_plazos" placeholder="" class="col-md-2" value="<?= $sumario['fecha_plazos']?>" required>
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_defensa">Plazo para que el inculpado pueda rendir pruebas:</label> <!-- en caso de que el inculpado solicite presentar descargos -->
                <input name="fecha_defensa" data-rel="tooltip"  type="date" id="fecha_defensa" placeholder="" class="col-md-2" value="<?= $sumario['fecha_defensa']?>" required>
                </div>
                </div>
            <?php endif;?>

<!-- Prórroga Formulación de Cargos -->
            <?php if($sumario['etapa']== 6):?>

                
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_defensa">Plazo por fiscal para rendir pruebas:</label>
                <input name="fecha_defensa" data-rel="tooltip"   <?php if($sumario['etapa']==6){ echo 'readonly'; }?> type="date" id="fecha_defensa" placeholder="" class="col-md-2" value="<?= $sumario['fecha_defensa']?>" >
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Fecha de Prórroga:</label>
                <input name="fecha_prorroga" data-rel="tooltip"  type="date" id="fecha_prorroga" placeholder="" class="col-md-2" value="<?= $sumario['fecha_prorroga']?>">
                </div>
                </div>
            <?php endif;?>

            <?php if($sumario['etapa']== 7):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Fecha de Prórroga:</label>
                <input name="fecha_prorroga" data-rel="tooltip"  <?php if($sumario['etapa']==7){ echo 'readonly'; }?> type="date" id="fecha_prorroga" placeholder="" class="col-md-2" value="<?= $sumario['fecha_prorroga']?>">
                </div>
                </div>
            <?php endif;?>     

            
<!-- SOBRESEIMIENTO -->
<?php if($sumario['etapa']== 7 && $sumario['sentencia'] == 4):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="plazo_fiscal">Plazo Investigación Fiscal:</label>
                <input name="plazo_fiscal" data-rel="tooltip" <?php if($sumario['etapa']== 4 && $sumario['sentencia'] == 3){ echo 'readonly'; }?> type="date" id="plazo_fiscal" placeholder="" class="col-md-2" value="<?= $sumario['plazo_fiscal']?>">
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sob">Nuevo Plazo Investigación Fiscal:</label>
                <input name="fecha_sob" data-rel="tooltip"  type="date" id="fecha_sob" placeholder="" class="col-md-2" value="<?= $sumario['fecha_sob']?>">
                </div>
                </div>
                <br>
                
            <?php endif;?>
            
<!----
            <?php if($sumario['etapa']== 8):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">TÉRMINO SUMARIO</label>
                <input name="fecha_not" data-rel="tooltip"type="date" id="fecha_not" placeholder="" class="col-md-2" value="<?= $sumario['fecha_not']?>">
                </div>
                </div>
            <?php endif;?>
            -->

            <!-- Sanción/Absolución Fiscal -->
            <?php if($sumario['etapa']== 9):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Fecha Procedimiento Fiscal/ Dictamen Sumario</label>
                <input name="fecha_resolucion" data-rel="tooltip"  type="date" id="fecha_resolucion" placeholder="" class="col-md-2" value="<?= $sumario['fecha_resolucion']?>">
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
                                    <div id="carpeta" class="form-group" enctype="multipart/form-data">
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
                <div class="form-group">
                <label class="col-md-2 control-label" for="obs_sumario">Observaciones:</label>
                <textarea name="obs_sumario" maxlength="255" data-rel="tooltip"  type="text" id="obs_sumario" rows="5" placeholder="" class="col-md-6" value="<?= $sumario['obs_sumario']?>" ></textarea>
                </div>
                </div>
                <br>
                <?php endif;?>

                
            <?php if($sumario['etapa']== 10):?>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Fecha Procedimiento Fiscal</label>
                <input name="fecha_resolucion" data-rel="tooltip"  <?php if($sumario['etapa']==10){ echo 'readonly'; }?> type="date" id="fecha_resolucion" placeholder="" class="col-md-2" value="<?= $sumario['fecha_resolucion']?>">
                </div>
                </div>
                <br>
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Término Sumario</label>
                <input name="fecha_reposicion" data-rel="tooltip" type="date" id="fecha_reposicion" placeholder="" class="col-md-2" value="<?= $sumario['fecha_reposicion']?>">
                </div>
                </div>
            <?php endif;?>

            <?php if($sumario['etapa']== 11):?>
         
                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="fecha_sumario">Término Sumario</label>
                <input name="fecha_reposicion" data-rel="tooltip" type="date" id="fecha_reposicion" placeholder="" class="col-md-2" value="<?= $sumario['fecha_reposicion']?>">
                </div>
                </div>
            <?php endif;?>
           
<!--
            <?php if($sumario['etapa']==12 && $sumario['sentencia'] == 8):?>

                <div class="row">
                <div class="form-group">
                <label class="col-md-2 control-label" for="multa">Valor multa</label>
                <input name="multa" data-rel="tooltip" type="text" id="multa" placeholder="" class="col-md-2" value="<?= $sumario['multa']?>">
                </div>
                </div>
            <?php endif;?>    -->
            
            <br>



<!-- BOTONES -->
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

                <?php if($sumario['etapa'] >= 1) :?>
                <button class="btn btn-info" type="submit" value="upload">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Guardar
                </button>
                <?php endif;?>

                <?php if($sumario['etapa'] == 2) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Resolución
                </button>
                <?php endif;?>

                <?php if($sumario['etapa'] == 7) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Resolución Fiscal
                </button>
                <?php endif;?>

                <?php if($sumario['etapa'] == 10) :?>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                    Término Sumario
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

                <?php if($sumario['etapa'] == 2) :?> <!-- fiscal debe cerrar contador y notificar de la resolución -->
                    <h4>Notificación de la Resolución </h4>   
                <?php endif;?>  

                <?php if($sumario['etapa'] == 4) :?>
                    <h4> Resolución </h4>   
                <?php endif;?>  

                <?php if($sumario['etapa'] == 7) :?> 
                    <h4> Dictamen Fiscal </h4>   
                <?php endif;?>    

                <?php if($sumario['etapa'] == 10) :?> 
                    <h4> Dictamen Secretario General </h4>   
                <?php endif;?>    

            </div>

            <div class="modal-footer">

                <?php if($sumario['etapa'] == 0) :?>
                    <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/editarSumario/".$this->uri->segment(4).'/'.'2')?> >ACEPTADA</a> <!-- 2 es Aceptada, 1 es rechazada-->

                    <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/editarSumario/".$this->uri->segment(4).'/'.'1')?> >RECHAZADA</a>
            
                <?php endif;?> 

                <?php if($sumario['etapa'] == 2) :?>

                <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/sobreseimiento/".$this->uri->segment(4).'/'.'3')?> >Sobreseimiento</a> 
                <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/cargos/".$this->uri->segment(4).'/'.'4')?> >Formulación de cargos</a>
                <?php endif;?> 

                <?php if($sumario['etapa'] == 7) :?>

                <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/absolucionFiscal/".$this->uri->segment(4).'/'.'5')?> >ABSOLUCIÓN</a>
                <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/sancionFiscal/".$this->uri->segment(4).'/'.'6')?> >SANCIÓN</a>
                <?php endif;?>  

                
                <?php if($sumario['etapa'] == 10) :?>

                <a type="button" class="btn btn-success" href=<?= site_url("Proc/SumarioSalud/finalizarSumario/".$this->uri->segment(4).'/'.'7')?> >AMONESTACIÓN</a>
                <a type="button" class="btn btn-info" href=<?= site_url("Proc/SumarioSalud/finalizarSumario/".$this->uri->segment(4).'/'.'8')?> >MULTA</a>
                <a type="button" class="btn btn-warning" href=<?= site_url("Proc/SumarioSalud/finalizarSumario/".$this->uri->segment(4).'/'.'9')?> >SUSPENSIÓN</a>
                <a type="button" class="btn btn-danger" href=<?= site_url("Proc/SumarioSalud/finalizarSumario/".$this->uri->segment(4).'/'.'10')?> >DESTITUCIÓN</a>
                <?php endif;?>  


            </div>
        </div>
        </div>
    </div>                
    </div>
    </div>  
</div>