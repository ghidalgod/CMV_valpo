<!-- Autor: Macelo Leiton  -->

<!-- Sección del botones con filtro según estados -->

<!-- Se declara la clase del boton y se obtiene el conteo de la data obtenida por los $indicadores  -->
<div class="col-xs-3">
		<div class="infobox-container">
			<h3 class="header smaller lighter green">Estado general</h3>
			
			<div class="infobox infobox-green " id='divCompletados' role='button'> <!-- El id es enviado o leido por el JS  -->
				<div class="infobox-icon">
					<i class="ace-icon fa fa-check"></i>
				</div>
				<div class="infobox-data">
					<div class="infobox-content center">Completados</div>
					<div class="infobox-data-number center"><?= count($indicadores[0])?></div>
				</div>
			</div>
			
			<div class="infobox infobox-orange " id='divEnCurso' role='button'> <!-- También se especifica el color del boton  -->
				<div class="infobox-icon">
					<i class="ace-icon fa fa-play"></i>
				</div>
				<div class="infobox-data">
					<div class="infobox-content center">En curso</div>
					<div class="infobox-data-number center"><?= count($indicadores[1]) ?></div>
				</div>
			</div>
			
			<div class="infobox infobox-red " id='divCancelado' role='button'>
				<div class="infobox-icon">
					<i class="ace-icon fa fa-eraser"></i>
				</div>
				<div class="infobox-data">
					<div class="infobox-content center">Cancelados</div>
					<div class="infobox-data-number center"><?= count($indicadores[2]) ?></div>
				</div>
			</div>
			
		</div>
</div>
	
<!-- Sección del grafico -->	
<div class="col-md-9">
	<h3 class="header smaller lighter purple center">
		<i class="ace-icon fa fa-signal "></i>
		Total pedidos por categoría <?php echo date("Y"); ?> <!-- Año actualizado automático -->
	</h3>
		
	<div class="infobox-container">
		<div class="widget-box transparent">
			<div class="widget-body">
				<div class="widget-main padding-4">
					<canvas id="myChart"></canvas> <!-- Muestra de la gráfica --> <!-- El id es enviado o leido por el JS  -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Sección DataTable -->
<div>
	<h3 class="header smaller lighter blue">Lista de Pedidos Droguería</h3>
	<div class="clearfix">
   <div class="pull-right tableTools-container"></div>
</div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table><!-- El id es enviado o leido por el JS  -->
</div>