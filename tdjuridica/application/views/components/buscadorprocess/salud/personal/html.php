<div class="row">
	
	<div class="col-xs-5">

		<div class="infobox-container">
			<h3 class="header smaller lighter green">Estado general</h3>
			
			<div class="infobox infobox-green infobox-small">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-check"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">Completados</div>
					<div class="infobox-content"><?= $indicadores[0] ?></div>
				</div>
			</div>
			<div class="infobox infobox-green infobox-small">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-play"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">En curso</div>
					<div class="infobox-content"><?= $indicadores[1] ?></div>
				</div>
			</div>
			<div class="infobox infobox-green infobox-small">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-eraser"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">Borrador</div>
					<div class="infobox-content"><?= $indicadores[2] ?></div>
				</div>
			</div>
			
		</div>
		
		<div class="infobox-container">
			<h3 class="header smaller purple">Reemplazos activos</h3>
			
			<div class="infobox infobox-purple" id='divActivas' role='button'>
				<div class="infobox-icon">
					<i class="ace-icon fa fa-file-text-o"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">Activos</div>
					<div class="infobox-content"><?= count( $indicadores[3] ) ?></div>
				</div>
			</div>
			<div class="infobox infobox-purple" id="divVencen7" role="button">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-calendar"></i>
				</div>
	
				<div class="infobox-data">
					<div class="infobox-content">Vencen de 1~7 dias</div>
					<div class="infobox-content"><?= count( $indicadores[4] ) ?></div>
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
							<a data-toggle="tab" href="#reemplazos-tab"><span class="label label-info"> Reemplazo </span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#prorrogas-tab"><span class="label label-success"> Prorroga </span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#ampliacion-tab"><span class="label label-yellow"> Ampliación </span></a>
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
						                    <th><span class="label label-info"> Tarea: Proceso Reemplazo </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>Autorización Director CESFAM</td>
						                    <td><?= $indicadores[5][0] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Validación Área de Salud</td>
						                    <td><?= $indicadores[5][1] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Arreglo Solicitud de Reemplazo</td>
						                    <td><?= $indicadores[5][2] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Revalidación Solicitud de Reemplazo</td>
						                    <td><?= $indicadores[5][3] ?></td>
						                </tr>
						                <tr>    
						                    <td>Aprobación Director de Salud</td>
						                    <td><?= $indicadores[5][4] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
							
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th><span class="label label-info"> Tarea: Proceso Reemplazo </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>Confección Contrato</td>
						                    <td><?= $indicadores[5][5] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Firma Contrato</td>
						                    <td><?= $indicadores[5][6] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Carga de Remuneraciones</td>
						                    <td><?= $indicadores[5][7] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Recepción CESFAM</td>
						                    <td><?= $indicadores[5][8] ?></td>
						                </tr>
						                <tr>    
						                    <td>Notificación de Rechazo</td>
						                    <td><?= $indicadores[5][9] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
							
						</div>
						
						<div id="prorrogas-tab" class="tab-pane">
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th><span class="label label-success"> Tarea: Proceso Prorroga </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>Autorización Director CESFAM</td>
						                    <td><?= $indicadores[6][0] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Validación Área de Salud</td>
						                    <td><?= $indicadores[6][1] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Arreglo Solicitud de Prórroga</td>
						                    <td><?= $indicadores[6][2] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Revalidación Solicitud de Prórroga</td>
						                    <td><?= $indicadores[6][3] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Aprobación Director de Salud</td>
						                    <td><?= $indicadores[6][4] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
												
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th><span class="label label-success"> Tarea: Proceso Prorroga </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>Confección Contrato</td>
						                    <td><?= $indicadores[6][5] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Carga de Remuneraciones</td>
						                    <td><?= $indicadores[6][6] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Recepción CESFAM</td>
						                    <td><?= $indicadores[6][7] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Notificación de Rechazo</td>
						                    <td><?= $indicadores[6][8] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
						</div>
						
						<div id="ampliacion-tab" class="tab-pane">
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th><span class="label label-yellow"> Tarea: Proceso Ampliación </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
						                    <td>Autorización Director CESFAM</td>
						                    <td><?= $indicadores[7][0] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Validación Área de Salud</td>
						                    <td><?= $indicadores[7][1] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Arreglo Solicitud de Asignación Horaria</td>
						                    <td><?= $indicadores[7][2] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Revalidación Solicitud de Asignación Horaria</td>
						                    <td><?= $indicadores[7][3] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Aprobación Director de Salud</td>
						                    <td><?= $indicadores[7][4] ?></td>
						                </tr>
						            </tbody>
						        </table>
							</div>
												
							<div class="col-xs-6">
								<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						            <thead>
						                <tr>
						                    <th><span class="label label-yellow"> Tarea: Proceso Ampliación </span></th>
						                    <th>Cantidad</th>
						                </tr>
						            </thead>
						            <tbody>
						                <tr>
							                <td>Confección Contrato</td>
						                    <td><?= $indicadores[7][5] ?></td>
						                </tr>
						
						                <tr>
						                    <td>Firma Contrato</td>
						                    <td><?= $indicadores[7][6] ?></td>
						
						                </tr>
						                
						                <tr>
						                    <td>Carga de Remuneraciones</td>
						                    <td><?= $indicadores[7][7] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Recepción CESFAM</td>
						                    <td><?= $indicadores[7][8] ?></td>
						                </tr>
						                
						                <tr>    
						                    <td>Notificación de Rechazo</td>
						                    <td><?= $indicadores[7][9] ?></td>
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

<div class="clearfix">
	<div class="pull-left">
		<span class="label label-info"> Procesos de reemplazo </span>
		<span class="label label-success"> Procesos de prorrogas </span>
		<span class="label label-yellow"> Procesos de ampliaciones horarias </span>
	</div>
   <div class="pull-right tableTools-container"></div>
</div>

<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>

<div class="row">
	<div class="col-sm-12">
		<h3 class="row header smaller lighter blue">
			<span class="col-xs-6"> Mapa de los procesos de salud </span>
		</h3>

		<div id="accordion" class="accordion-style1 panel-group">
		    
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp; Proceso de reemplazos
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseOne">
					<div class="panel-body">
						<img src="<?= base_url('assets/images/view/buscadorprocess/salud/prs.png') ?>" width="100%"  height="auto" alt="mapa proceso reemplazo" />
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp; Proceso de prorrogas
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseTwo">
					<div class="panel-body">
					    <img src="<?= base_url('assets/images/view/buscadorprocess/salud/pps.png') ?>" width="100%"  height="auto" alt="mapa proceso reemplazo" />
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
							<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp; proceso de ampliación horario
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseThree">
					<div class="panel-body">
                        <img src="<?= base_url('assets/images/view/buscadorprocess/salud/pas.png') ?>" width="100%"  height="auto" alt="mapa proceso reemplazo" />
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
</div>