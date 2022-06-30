<div id="sidebar" class="sidebar responsive ace-save-state" data-sidebar="true" data-sidebar-scroll="true"
    data-sidebar-hover="true">
    <script type="text/javascript">
        try { ace.settings.loadState('sidebar') } catch (e) { }
    </script>

    <ul class="nav nav-list" style="top: 0px;">
    	<!-- Inicio -->
        <li class="<?= array('inicio') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>"> <!--Compara los elementos del array $menu_item enviados por el controlador dentro de la variable $data, si se cumple, en la vista, el menu se selecciona pintando una flecha azul y en caso de contener submenus se despliegan -->
            <a href="<?= site_url('InicioFuncionario') ?>">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> Inicio </span>
            </a>
            <b class="arrow"></b>
        </li>
        
		<!-- Información Personal -->
        <li class="<?= array('infoPersonal') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right"></i>
                Datos personales
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
            	<!-- Sub menu: Formación o Profesión -->
                <li class="<?= array('formacion') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
                    <a href="<?= site_url('Formacion') ?>">
                        <i class="menu-icon fa fa-search"></i>
                        Información de formación o profesional
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        
        <!-- Información Contractual -->
	    <li class="<?= array('contratos') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
	    		<a href="<?= site_url('DatosContractuales') ?>">
	            <i class="menu-icon fa fa-file-text"></i>
	            <span class="menu-text"> Datos contractuales </span>
	        </a>
	        <b class="arrow"></b>
	    </li>
	    
        <!-- Permisos y Vacaciones -->
	    <li class="<?= array('permisos') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
	    		<a href="<?= site_url('Permisos') ?>">
	            <i class="menu-icon fa fa-file-text"></i>
	            <span class="menu-text"> Permisos/Vacaciones </span>
	        </a>
	        <b class="arrow"></b>
	    </li>
	    
		<!-- Remuneraciones -->
        <li class="<?= array('remuneraciones') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right"></i>
                Remuneraciones
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
            	<!-- Sub menu: Datos remuneración -->
                <li class="<?= array('datosRemuneracion') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
                    <a href="<?= site_url('DatosRemuneracion') ?>">
                        <i class="menu-icon fa fa-search"></i>
                        Datos remuneración
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="<?= array('tipoPago') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
                    <a href="<?= site_url('TipoPago') ?>">
                        <i class="menu-icon fa fa-search"></i>
                        Tipo de pago
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="<?= array('prevision') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
                    <a href="<?= site_url('Prevision') ?>">
                        <i class="menu-icon fa fa-search"></i>
                        Previsión
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="<?= array('liquidaciones') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
                    <a href="<?= site_url('Liquidaciones') ?>">
                        <i class="menu-icon fa fa-search"></i>
                        Liquidaciones
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>	    
        
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-save-state ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
            data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>