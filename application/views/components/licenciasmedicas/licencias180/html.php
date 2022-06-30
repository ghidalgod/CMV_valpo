<h3 class="header lighter green">Funcionarios con tope de 180 días:</h3>
<h4 class="smaller lighter green">En este listado se muestran las personas que, dentro de un rango de 2 años, tienen más de 180 días de licencia acumulados (Periodo desde el <?=date("d/m/Y",strtotime(date("m/d/Y")."- 2 years")) ." al ". date("d/m/Y") ?>)</h4>
<div>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"></table>
</div>