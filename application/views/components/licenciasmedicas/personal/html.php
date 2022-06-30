
<div class="row">
	<div class="col-xs-4">
		<h3 class="header smaller lighter green">Estado general</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divActivas" class="infobox infobox-green">
				<div class="infobox-icon">
						<i class="ace-icon fa fa-stethoscope"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['activas'])?></span>
					<div class="infobox-content">Licencias Activas</div>
				</div>
			</div>
				
			<div role="button" id="divVencen7" class="infobox infobox-red">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-stethoscope"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['vencen7dias'])?></span>
					<div class="infobox-content">Vencen en 7 dias</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-4">
		<h3 class="header smaller lighter blue">Últimos 30 dias</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divUltimos30" class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-file-text-o"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['ultimo30dias'])?></span>
					<div class="infobox-content">Cantidad</div>
				</div>
			</div>
				
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-calendar"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= $reporte['ultimo30diastotal']?></span>
					<div class="infobox-content">Total en dias</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-4">
		<h3 class="header smaller lighter purple">Ultimo 180 dias</h3>
		
		<div class="infobox-container">
		
			<div role="button" id="divUltimos365" class="infobox infobox-purple">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-file-text-o"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= count($reporte['ultimo365dias'])?></span>
					<div class="infobox-content">Cantidad</div>
				</div>
			</div>
				
			<div class="infobox infobox-purple">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-calendar"></i>
				</div>
	
				<div class="infobox-data">
					<span class="infobox-data-number"><?= $reporte['ultimo365diastotal']?></span>
					<div class="infobox-content">Total en dias</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="col-xs-12">
		<h3 class="header smaller lighter green">Lista de Licencias:</h3>
		<div class="clearfix">
			<div class="pull-left">
				<span class="label label-success"> Correo Enviado </span>
				<span class="label label-yellow"> Correo No Enviado </span>
				<span class="label arrowed">Licencia Electronica</span>
				<span class="label label-info">Licencia en papel</span>
			</div>
		   <div class="pull-right tableTools-container"></div>
		</div>
		<div>
	    	<table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
		</div>
	</div>
</div>
