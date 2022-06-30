<div class="row">
	<div class="col-xs-6">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Cargar Excel</h4>
			</div>
	
			<div class="widget-body">
				<div class="widget-main">
					<?= form_open_multipart('DbManager/index', 'class="form-horizontal" role="form"'); ?>
						<div class="form-group">
							<div class="col-xs-12">
								<!--<input name="xlsx" accept=".xlsx" type="file" id="id-input-file" />-->
								<?php echo form_upload($data_excel);?>
							</div>
						</div>
						<div class="row form-group col-xs-12">
								<!--<input name="xlsx" accept=".xlsx" type="file" id="id-input-file" />-->
								<label class="col-xs-2 control-label" for="table_name">Tabla  </label>
								<?php echo form_dropdown($table_name);?>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<input type="submit" class="btn btn-primary btn-block" value="Cargar">
							</div>
						</div>
					<?= form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="infoMessage"><?php echo $message;?></div>