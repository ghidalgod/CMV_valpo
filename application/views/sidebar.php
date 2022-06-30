<div id="sidebar" class="sidebar responsive ace-save-state" data-sidebar="true" data-sidebar-scroll="true"
    data-sidebar-hover="true">
    <script type="text/javascript">
        try { ace.settings.loadState('sidebar') } catch (e) { }
    </script>

	<!-- Menú -->
    <ul class="nav nav-list" style="top: 0px;">
    	<!-- Item: Inicio -->
        <li class="<?= array('inicio') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>"> <!--Compara los elementos del array $menu_item enviados por el controlador dentro de la variable $data, si se cumple, en la vista, el menu se selecciona pintando una flecha azul y en caso de contener submenus se despliegan -->
            <a href="<?= site_url('inicio') ?>">
                <i class="menu-icon fa fa-home"></i> <!-- Icono del menu -->
                <span class="menu-text"> Inicio </span> <!-- Nombre que se mostrara del menu -->
            </a>
            <b class="arrow"></b>
        </li>

        <!-- Item: Licencias médicas -->
        <li class="<?= array('licenciasMedicas') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
            <a href="<?= site_url('LicenciasMedicas/administrador') ?>">
                <i class="menu-icon fa fa-stethoscope"></i>
                <span class="menu-text"> Licencias Médicas </span>
            </a>
            <b class="arrow"></b>
        </li>
        
        <!-- Menu Dias libres -->
        <li class="<?= array('diaslibres') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
        		<a href="<?= site_url('DiasLibres/admin') ?>">
                <i class="menu-icon fa fa-plane"></i>
                <span class="menu-text"> Días Libres </span>
            </a>
            <b class="arrow"></b>
        </li><!-- FIN Menu Dias libres -->
        
          <!-- Menu Pedidos Drogueria -->
        <?php if ($this->ion_auth->in_group(array('admin','bpdrogueria'))): ?>
        <li class="<?= array('bpdrogueria') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
        			<a href="<?= site_url('Buscadorprocess/pedidoDrogueria') ?>">
                <i class="menu-icon fa fa-medkit"></i>
                <span class="menu-text"> Pedidos Droguería</span>
            </a>
            <b class="arrow"></b>
        </li> <?php endif; ?><!-- FIN Menu Pedidos Drogueria -->
        
        
		<!-- Menu Utilidades -->
        <li class="<?= array('utilidades') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-files-o"></i>
                <span class="menu-text"> Utilidades </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Utilidades: Sub menu Anexos -->
        		<li class="<?= array('utilidades', 'anexos') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            		<a href="<?= site_url('Anexos') ?>">
                		<i class="menu-icon fa fa-address-book-o"></i>
                		Anexos
            		</a>
        		</li>
				<!-- Menu Utilidades: Sub menu Documentos -->
				<li class="<?= array('utilidades','documentos') === array_slice($menu_items, 0, 2) ? 'active open' : '' ?>">
            		<a href="#" class="dropdown-toggle">
                		<i class="menu-icon fa fa-file-text"></i>
                		Documentos
                		<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
                    	<!-- Sub menu Utilidades: Políticas y Reglamentos. -->
                        <li class="<?= array('utilidades', 'documentos', 'reglamentos') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="<?= site_url('Reglamentos') ?>">
                                <i class="menu-icon fa fa-search"></i>
                                Políticas y Reglamentos.
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <!-- Sub menu Utilidades: Procedimientos e instructivos. -->
                        <li class="<?= array('utilidades', 'documentos', 'instructivos') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="<?= site_url('Instructivos') ?>">
                                <i class="menu-icon fa fa-line-chart"></i>
                                Procedimientos e Instructivos.
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
				</li>
				<!-- Menu Utilidades: Sub menu Links -->
				<li class="<?= array('utilidades', 'links') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
                    <a href="#">
                        <i class="menu-icon fa fa-link"></i>
                        Links
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li> <!-- FIN Menu Utilidades -->
        
       
		<!-- Menu Administrador -->
        <li class="<?= array('auth') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Administrador </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Administrador: Sub menu Gestión de usuarios -->
				<li class="<?= array('auth','user') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
					<a href="#" class="dropdown-toggle">
	                	<i class="menu-icon fa fa-address-book"></i>
	                	<span class="menu-text"> Gestión de Usuarios</span>
	                <b class="arrow fa fa-angle-down"></b>
	            </a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!-- Sub menu Gestión de usuarios: Lista -->
						<li class="<?= array('auth','user','list') === array_slice($menu_items, 0, 2) ? 'active open' : '' ?>">
							<a href="<?= site_url('auth') ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Lista
							</a>
							<b class="arrow"></b>
	                	</li>
						<!-- Sub menu Gestión de usuarios: Crear usuario -->
						<li class="<?= array('auth','user','create') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
							<a href="<?= site_url('auth/create_user') ?>">
	                        	<i class="menu-icon fa fa-caret-right"></i>
	                        	Crear Usuario
	                    	</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				<!-- Menu Administrador: Sub menu Avisos -->
				<li class="<?= array('auth', 'aviso') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
                    <a href="<?= site_url('Noticias') ?>">
                        <i class="menu-icon fa fa-exclamation-circle"></i>
                        Noticias
                    </a>
                    <b class="arrow"></b>
                </li>
                
                <!-- Menu Administrador: Sub menu cargas DB -->
				<li class="<?= array('auth','dbmanager') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
                    <a href="<?= site_url('DbManager') ?>">
                        <i class="menu-icon fa fa-database"></i>
                        Admin DB
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li> <!-- FIN Menu Administrador -->
    </ul>


    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-save-state ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
            data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>