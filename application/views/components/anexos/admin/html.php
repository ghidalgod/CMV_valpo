<!-- Button to trigger modal -->
<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#addModal">Agregar Anexo </button>

<!-- Modal -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 id="myModalLabel">Agregar nuevo Anexo</h4>
            </div>
            	
            <!--<div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form">
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Enter your name"/>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email"/>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Message</label>
                        <textarea class="form-control" id="inputMessage" placeholder="Enter your message"></textarea>
                    </div>
                </form>
            </div> Modal Body -->
            <div class="modal-body">
	            <div class="row">
				    <div class="col-xs-12">
						<?= form_open(site_url('Anexos/addnew'), 'class="form-horizontal" role="form"') ?>
				        	<h3 class="header smaller lighter green">Datos del anexo</h3>
				
				            <div class="form-group">
				                <label class="col-sm-4 control-label no-padding-right" for="nombre">Nombre: </label>
				                <div class="col-sm-8">
				                    <input name="nombre" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('nombre') ?>">
				                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Nombre del usuario con anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
				                </div>
				            </div>
				
				            <div class="form-group">
				                <label class="col-sm-4 control-label no-padding-right" for="anexo">Anexo: </label>
				                <div class="col-sm-8">
				                    <input name="anexo" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('anexo') ?>">
				                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Número de anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
				                </div>
				            </div>
				
				            <div class="form-group">
				                <label class="col-sm-4 control-label no-padding-right" for="cargo">Cargo: </label>
				                <div class="col-sm-8">
				                    <input name="cargo" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('cargo') ?>">
				                </div>
				            </div>
				
				            <div class="form-group">
				                <label class="col-sm-4 control-label no-padding-right" for="departamento">Departamento o dirección: </label>
				                <div class="col-sm-8">
				                    <input name="departamento" data-rel="tooltip" type="text" id="departamento" class="col-xs-10 col-sm-6" value="<?= set_value('departamento') ?>">
				                    <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Departamento o dirección a la que pertenece el anexo" title="Obligatorio" data-original-title="Condiciones">?</span>
				                </div>
				            </div>
				
				            <div class="form-group">
				                <label class="col-sm-4 control-label no-padding-right" for="email">Email: </label>
				                <div class="col-sm-8">
				                    <input name="email" data-rel="tooltip" type="text" class="col-xs-10 col-sm-6" value="<?= set_value('email') ?>">
				                </div>
				            </div>
				
				            <div class="clearfix form-actions center">
				                <button class="btn btn-info" type="submit" name="finalizar">
				                    <i class="ace-icon fa fa-check bigger-110"></i>
				                    Finalizar
				                </button>
				                <a href="<?= site_url("anexos/index")?>" class="btn btn-danger">
				                    <i class="ace-icon fa fa-close bigger-110"></i>
				                    Cancelar
				                </a>
				            </div>
				        </form>
				    </div>  
				</div>
			</div>
            <!-- Modal Footer -->
        </div>
    </div>
</div>

<h3 class="header smaller lighter green">Lista de anexos:</h3>
<div class="row">
    <div class="col-xs-12">
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>

        <!-- div.table-responsive -->

        <!-- div.dataTables_borderWrap -->

        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
        </div>
    </div>
</div> 

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="delete-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="delete-modal-label">Eliminar Anexo</span></h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres eliminar el anexo: <b><span class="delete-modal-codigo"></span></b>?</p>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" data-loading-text="Cargando..." class="btn btn btn-danger loading-delete-btn" id="deleteButton">Eliminar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>