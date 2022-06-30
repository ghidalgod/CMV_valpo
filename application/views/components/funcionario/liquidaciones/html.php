<h2 class="header smaller lighter green" >Emisión de liquidaciones de sueldo</h2>
<br/>
<br/>
<div class="container panel panel-default">
	<div class="panel-body">
		 <?=form_open("Liquidaciones/emisionLiquidaciones", 'id="formPeriodo" role="form" target="_blank" rel="noopener noreferrer"'); ?>
			<div class="row">
				<div class="col-md-3">
					<strong>Período remuneraciones desde:</strong>
				</div>
				<div class="col-md-2">
					<?=form_dropdown('mesDesde', $meses, "", $mesDesde);?>
				</div>
				<div class="col-md-2">
					<?=form_dropdown('anioDesde', $anios, "", $anioDesde);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<strong>Período remuneraciones hasta:</strong>
				</div>
				<div class="col-md-2">
					<?=form_dropdown('mesHasta', $meses, "", $mesHasta);?>
				</div>
				<div class="col-md-2">
					<?=form_dropdown('anioHasta', $anios, "", $anioHasta);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<button id="liquidaciones-btn" class="btn btn-primary">
						<i class="ace-icon fa fa-search align-top bigger-125"></i>
						Generar liquidaciones
					</button>
				</div>
			</div>
		<?=form_close();?>
        <div id="divError" class="row alert alert-danger hidden" >
            <strong>
                <i class="ace-icon fa fa-times"></i>
                La fecha de inicio debe ser menor a la de término
            </strong>
        </div>
	</div>
</div>