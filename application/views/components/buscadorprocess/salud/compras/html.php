<div class="row">
	
	<div class="col-xs-5">

		<div class="infobox-container">
			<h3 class="header smaller lighter green">Estado general</h3>
			
			<div class="infobox infobox-green infobox">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-check"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">Completados</div>
					<div class="infobox-content"><?= $indicadores[0] ?></div>
				</div>
			</div>
			<div class="infobox infobox-green infobox">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-play"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">En curso</div>
					<div class="infobox-content"><?= $indicadores[1] ?></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-7">
		<div class="widget-box transparent">
			<div class="widget-header">
				<h3 class="widget-title lighter smaller"> Resumen por etapa (Solo casos "En curso")	</h3>
				
				<div class="widget-toolbar no-border">
					<ul class="nav nav-tabs" id="recent-tab">
						<li class="active">
							<a data-toggle="tab" href="#reemplazos-tab">Compras</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div class="widget-body">
				<div class="widget-main padding-4">
					<div class="tab-content padding-8">
						<div id="reemplazos-tab" class="tab-pane active">
							
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th>Tarea</th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>1.1)Autorización director CESFAM</td>
						                    <td><?= $indicadores[2][0] ?></td>
						                </tr>
						
						                <tr>
						                    <td>2) Evaluar Requerimiento</td>
						                    <td><?= $indicadores[2][1] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>3) Evaluación director Area Salud</td>
						                    <td><?= $indicadores[2][2] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>4) Compra del Requerimiento (Solicitud CDP)</td>
						                    <td><?= $indicadores[2][3] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
							
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th>Tarea</th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>5) Compra del Requerimiento (Generación OC)</td>
						                    <td><?= $indicadores[2][4] ?></td>
						                </tr>
						
						                <tr>
						                    <td>6) Recepción y envío de evidencia</td>
						                    <td><?= $indicadores[2][5] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>7) Validación de Evidencia</td>
						                    <td><?= $indicadores[2][6] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Notificación de Rechazo</td>
						                    <td><?= $indicadores[2][7] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
							
						</div>
						
						
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<span class="label label-info">Fondo a rendir </span>
<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>

<div class="row">
	<div class="col-sm-12">
		<h3 class="row header smaller lighter blue">
			<span class="col-xs-6"> Mapa del proceso compras de salud </span>
		</h3>

		<div id="accordion" class="accordion-style1 panel-group">
		    
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp; Proceso de Compras salud
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseOne">
					<div class="panel-body">
						<img src="<?= base_url('assets/images/view/buscadorprocess/salud/pcs.png') ?>" width="100%"  height="auto" alt="mapa proceso reemplazo" />
					</div>
				</div>
			</div>

		</div>
		
	</div>
</div>