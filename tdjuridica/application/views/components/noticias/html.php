<div>
	<div class="row"><?php echo validation_errors(); ?></div>
	<div claas="row">
			<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#noticiaModal">
			<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
			Agregar Noticia
		</button>

		<!-- Modal -->
		<div class="modal fade" id="noticiaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" id="noticiaM" role="document">
		    	<div class="modal-content">
		    		<div class="modal-header">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          			<span aria-hidden="true">&times;</span>
		        		</button>
		        		<h2 class="header smaller lighter green">Agregar Noticias</h2>
		      		</div>
		      		<div class="modal-body">
		        		<div class="col">
					<?= form_open(uri_string());?>
					<div class="widget-box">
			    		<div class="widget-body">
			        		<div class="widget-main">
								<div class="row form-group">
									<label class="col-sm-3 control-label no-padding-right" for="titulo"> Título </label>
									<div class="col-sm-9">
										<?= form_input(['type="text" name="titulo" id="titulo" placeholder="Título" class="form-control"']);?>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 control-label no-padding-right" for="cuerpo"> Cuerpo </label>
									<div class="col-sm-9">
										<textarea name="cuerpo" id="editor" rows="8" cols="45"></textarea>
									</div>
								</div>
								<div class="row from-group">
									<label class="col-sm-3 control-label no-padding-right" for="tipo"> Tipo </label>
									<div class="col-sm-9">
										<input type="radio" name="tipo" value="Social"><label>Social</label>
										<input type="radio" name="tipo" value="General"><label>General</label>
										<input type="radio" name="tipo" value="Administrativo"><label>Administrativo</label>
									</div>
								</div>
								<div class="space-4"></div>
			    		    </div>
					    </div>
				    </div>
				</div>
		      		</div>
		      		<div class="modal-footer">
		        		<?php echo form_submit('submit', 'Guardar',"class='btn btn-sm btn-primary'");?>
		      		</div>
		      		</form>
		      		<?php echo form_close();?>
		    	</div>
		  	</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<!--LISTA DE NOTICIAS-->
		<div class="col-md-12 center">
			<table id="myTable" class="table table-striped table-bordered table-hover">
		
			</table>
		</div>
	</div>
</div>
<?php echo form_close();?>