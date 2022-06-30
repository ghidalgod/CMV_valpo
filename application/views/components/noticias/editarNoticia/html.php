<h1 class="header smaller lighter blue">Editar Noticia</h1>
<div class="row">
	<div id="infoMessage" class="col"><p ><?php echo $message;?></p></div>
	<div class="row"><?php echo validation_errors(); ?></div>
</div>
<div class="col">
	<?= form_open(uri_string());?>
	<div class="widget-box">
		<div class="widget-body">
    		<div class="widget-main">
				<div class="row form-group">
					<label class="col-sm-3 control-label no-padding-right" for="titulo"> Título </label>
					<div class="col-sm-9">
						<?= form_input($titulo);?>
					</div>
				</div>
				<div class="row form-group">
					<label class="col-sm-3 control-label no-padding-right" for="cuerpo"> Cuerpo </label>
					<div class="col-sm-9">
						<i id="spinerOn" class="ace-icon fa fa-spinner fa-spin orange bigger-250" style="display"></i>
						<?= form_textarea($editor)?>
					</div>
				</div>
				<div class="row from-group">
					<label class="col-sm-3 control-label no-padding-right" for="tipo"> Tipo </label>
					<div class="col-sm-9">
						<?= form_radio($social)?><label>Social</label>
						<?= form_radio($general)?><label>General</label>
						<?= form_radio($administrativo)?><label>Administrativo</label>
					</div>
				</div>
				<div class="space-4"></div>
		    </div>
	    </div>
    </div>
    <div class="row center">
		<?php echo form_submit('submit', 'Actualizar',"class='btn btn-sm btn-primary'");?>
	</div>
	</form>
</div>
<?php echo form_close();?>