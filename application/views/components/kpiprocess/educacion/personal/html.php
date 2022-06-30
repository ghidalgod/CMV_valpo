<h3 class="header smaller lighter green">Cantidad de casos activos por día.</h3>
<div class="row">
	
    <div class="col-xs-12" style="overflow-x: scroll;">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Reemplazos</th>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Crear Solicitud de Reemplazo</td>
                   <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["9214721515c45deb1f0b588004039770"]) ? 0 : $value["9214721515c45deb1f0b588004039770"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación Jardin</td>
                   <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["4361483165dd5745c265616070974787"]) ? 0 : $value["4361483165dd5745c265616070974787"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación PIE</td>
                   <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["7050045335d65587320f2b2080178525"]) ? 0 : $value["7050045335d65587320f2b2080178525"] ?></td>
                    <?php endforeach ?>
                </tr>

                <tr>
                    <td>Validación Área de Educación</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["1970904545c45deb206f261098191784"]) ? 0 : $value["1970904545c45deb206f261098191784"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Aprobación Sub Directora de Educación</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["6868457525c45deb2198036056415719"]) ? 0 : $value["6868457525c45deb2198036056415719"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Entrega de Carta y Confección Contrato</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["7426494965c45deb2102915023858423"]) ? 0 : $value["7426494965c45deb2102915023858423"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Carga de Remuneraciones</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["4574224135c45deb20b9f93063375385"]) ? 0 : $value["4574224135c45deb20b9f93063375385"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Recepción Establecimiento</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["6015278045c45deb1e99996035107736"]) ? 0 : $value["6015278045c45deb1e99996035107736"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Notificación de Rechazo</td>
                    <?php foreach(array_reverse($kpi) as $key => $value): ?>
                    	<td><?= empty($value["3094454645c45deb1d11cb5038948715"]) ? 0 : $value["3094454645c45deb1d11cb5038948715"] ?></td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-12" style="overflow-x: scroll;">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Prorrogas</th>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Crear Solicitud de Prorroga</td>
                   <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["2223003495cc1b6b726daa2097528664"]) ? 0 : $value["2223003495cc1b6b726daa2097528664"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación Jardin</td>
                   <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["7862012735dd6b8ab6479e9059492106"]) ? 0 : $value["7862012735dd6b8ab6479e9059492106"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación PIE</td>
                   <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["5520675835d6d755532f5c3037801177"]) ? 0 : $value["5520675835d6d755532f5c3037801177"] ?></td>
                    <?php endforeach ?>
                </tr>

                <tr>
                    <td>Validación Área de Educación</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["9100553525cc1b6b7436634094139750"]) ? 0 : $value["9100553525cc1b6b7436634094139750"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Aprobación Sub Directora de Educación</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["4767213395cc1b6b7807f46055406310"]) ? 0 : $value["4767213395cc1b6b7807f46055406310"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Validación Personal</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["8862455525cc1b6b79dd813013068163"]) ? 0 : $value["8862455525cc1b6b79dd813013068163"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Carga de Remuneraciones</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["6928705435cc1b6b761f208061470290"]) ? 0 : $value["6928705435cc1b6b761f208061470290"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Recepción Establecimiento</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["4765612275cc1b6b6c440b3006493802"]) ? 0 : $value["4765612275cc1b6b6c440b3006493802"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Notificación de Rechazo</td>
                    <?php foreach(array_reverse($kpi2) as $key => $value): ?>
                    	<td><?= empty($value["1067326945cc1b6b6a78b51010523474"]) ? 0 : $value["1067326945cc1b6b6a78b51010523474"] ?></td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-12" style="overflow-x: scroll;">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Ampliaciónes</th>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Crear Solicitud de Ampliación</td>
                   <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["1608386405cf14e3b410392049298503"]) ? 0 : $value["1608386405cf14e3b410392049298503"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación carga horario</td>
                   <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["8994067395d44a156067236050354847"]) ? 0 : $value["8994067395d44a156067236050354847"] ?></td>
                    <?php endforeach ?>
                </tr>
                
                <tr>
                    <td>Validación Financiamiento</td>
                   <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["7518575255cf14e3b0f8b30090691663"]) ? 0 : $value["7518575255cf14e3b0f8b30090691663"] ?></td>
                    <?php endforeach ?>
                </tr>

                <tr>
                    <td>Validación Área de Educación</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["8696857175cf14e3b1c7cc2016902924"]) ? 0 : $value["8696857175cf14e3b1c7cc2016902924"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Aprobación Sub Directora de Educación</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["2339769845cf14e3b288619082606695"]) ? 0 : $value["2339769845cf14e3b288619082606695"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Validación y Carga datos</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["8626038035cf14e3ad91f20031325265"]) ? 0 : $value["8626038035cf14e3ad91f20031325265"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Confección de anexo</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["1727311535cfe763ab28a53014067762"]) ? 0 : $value["1727311535cfe763ab28a53014067762"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Recepción Establecimiento</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["9455296735cf14e3b0295b5014593812"]) ? 0 : $value["9455296735cf14e3b0295b5014593812"] ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>    
                    <td>Notificación de Rechazo</td>
                    <?php foreach(array_reverse($kpi3) as $key => $value): ?>
                    	<td><?= empty($value["6635905875cf14e3ae725e4076648408"]) ? 0 : $value["6635905875cf14e3ae725e4076648408"] ?></td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
