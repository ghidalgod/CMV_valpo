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

        <!--Procedimientos Juridica-->
        <?php if ($this->ion_auth->in_group(array(22,23))) : ?>
        <li class="<?= array('ProcedimientosJuridica/procedimientos') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
            <a href="<?= site_url('ProcedimientosJuridica/procedimientos') ?>">
                <i class="menu-icon fa fa-list-alt"></i>
                <span class="menu-text">Flujo Procedimientos</span>
            </a>
            <b class="arrow"></b>
        </li> 
         <?php endif; ?>

         <?php if ($this->ion_auth->in_group(array(22,23))) : ?>
        <li class="<?= array('causas') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
            <a href="<?= site_url('causas') ?>">
                <i class="menu-icon fa fa-list-alt"></i>
                <span class="menu-text">Flujo Causas</span>
            </a>
            <b class="arrow"></b>
        </li> 
        <?php endif; ?>
       

        
        <?php if ($this->ion_auth->in_group(array('bpeducacion','dotacion','bpkpi'))): ?>
		<!-- Menu Educación -->
        <li class="<?= array('educacion') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-graduation-cap"></i>
                <span class="menu-text"> Educación </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Educación: Sub menu Personal -->
                <li class="<?= array('educacion', 'personal') === array_slice($menu_items, 0, 2) ? 'active open' : '' ?>">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Personal
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                    	<!-- Sub menu Personal: Buscador Process -->
                    	<?php if ($this->ion_auth->in_group(array('bpeducacion'))): ?>
                        <li class="<?= array('educacion', 'personal', 'buscadorP') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="<?= site_url('Buscadorprocess') ?>">
                                <i class="menu-icon fa fa-search"></i>
                                Buscador Process
                            </a>
                            <b class="arrow"></b>
                        </li><?php endif; ?>
                        <!-- Sub menu Personal: Dotación -->
                        <?php if ($this->ion_auth->in_group('dotacion')): ?>
                        <li class="<?= array('educacion', 'personal', 'dotacion') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="<?= site_url('LicenciasMedicas/dotacion') ?>">
                                <i class="menu-icon fa fa-table"></i>
                                Dotación
                            </a>
                            <b class="arrow"></b>
                        </li><?php endif; ?>
                        <!-- Sub menu Personal: KPI -->
                        <?php if ($this->ion_auth->in_group('bpkpi')): ?>
                        <li class="<?= array('educacion', 'personal', 'kpi') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="<?= site_url('KpiProcess/personalEducacion') ?>">
                                <i class="menu-icon fa fa-line-chart"></i>
                                KPI
                            </a>
                            <b class="arrow"></b>
                        </li><?php endif; ?>
                    </ul>
                </li>
                <?php if ($this->ion_auth->in_group('developed')): ?>
                <!-- Menu Educación: Sub menu Adquisiciones -->
				<li class="<?= array('educacion', 'adquisiciones') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Adquisiciones
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                    	<!-- Sub menu Adquisiciones: Buscador Process -->
                        <li class="<?= array('educacion', 'adquisiciones', 'buscadorP') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="menu-icon fa fa-search"></i>
                                Buscador Process
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <!-- Sub menu Adquisiciones: Consulta Archivo OC -->
                        <li class="<?= array('educacion', 'adquisiciones', 'archivooc') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="menu-icon fa fa-tasks"></i>
                                Consulta Archivo OC
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <!-- Sub menu Adquisiciones: KPI -->
                        <li class="<?= array('educacion', 'adquisiciones', 'KPI') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="menu-icon fa fa-line-chart"></i>
                                KPI
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li><?php endif; ?>
            </ul> 
        </li><?php endif; ?> <!-- FIN Menu Educación -->
        
        <!-- Menu Salud -->
        <?php if ($this->ion_auth->in_group(array('bpsalud'))): ?>
        <li class="<?= array('salud', 'personal') === array_slice($menu_items, 0, 2) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-users"></i>
                <span class="menu-text"> Personal </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">

		        <li class="<?= array('salud', 'personal', 'buscadorP') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
	        		<a href="<?= site_url('Buscadorprocess/saludPersonal') ?>">
                                <i class="menu-icon fa fa-search"></i>
                                ProcessMaker
                            </a>
                    <b class="arrow"></b>
	            </li>


			   <li class="<?= array('salud', 'personal', 'igestion') === array_slice($menu_items, 0, 3) ? 'active' : '' ?>">
	               <a href="<?= site_url('Igestion/index') ?>">
	                   <i class="menu-icon fa fa-table"></i>
	                   I-gestion
	               </a>
	               <b class="arrow"></b>
	           </li>

		    </ul>
		</li>
		<?php endif; ?><!-- FIN Menu Salud -->
        
        <!-- Menu Dias libres -->
        <?php if ($this->ion_auth->in_group(array('dlibresAdd', 'dlibresView'))): ?>
        <li class="<?= array('diaslibres') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
        		<a href="<?= site_url('DiasLibres/resumen') ?>">
                <i class="menu-icon fa fa-plane"></i>
                <span class="menu-text"> Días Libres </span>
            </a>
            <b class="arrow"></b>
        </li> <?php endif; ?><!-- FIN Menu Dias libres -->
        
      
       <!-- Menu Licencias Medicas -->
		<?php if ($this->ion_auth->in_group(array('lmedicas','lmedicascentro','lmpersonal', 'lmedicas180'))): ?>
        <li class="<?= array('licenciasMedicas') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-stethoscope"></i>
                <span class="menu-text"> Licencias Médicas </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
		        <?php if ($this->ion_auth->in_group(array('lmedicas','lmedicascentro','lmpersonal', 'lmedicas180'))): ?>
			        <?php if ($this->ion_auth->in_group(array('lmedicas'))): ?>
				        <li class="<?= array('lmedicas') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
			        		<a href="<?= site_url('LicenciasMedicas/licenciasMedicas') ?>">
				                <i class="menu-icon fa fa-stethoscope"></i>
				                <span class="menu-text"> Licencias Médicas </span>
			                </a>
			                <b class="arrow"></b>
			            </li>
					<?php endif; ?>
			        <?php if ($this->ion_auth->in_group(array('lmedicascentro'))): ?>
			        	<li class="<?= array('lmedicascentro') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
			        		<a href="<?= site_url('LicenciasMedicas/reporte') ?>">
				                <i class="menu-icon fa fa-stethoscope"></i>
				                <span class="menu-text"> Licencias Médicas </span>
			                </a>
			                <b class="arrow"></b>
			            </li>
			        <?php endif; ?>
					<?php if ($this->ion_auth->in_group(array('lmpersonal'))): ?>
						<li class="<?= array('lmpersonal') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
			        		<a href="<?= site_url('LicenciasMedicas/personal') ?>">
				                <i class="menu-icon fa fa-stethoscope"></i>
				                <span class="menu-text"> LM Pago </span>
			                </a>
			                <b class="arrow"></b>
		            	</li>
					<?php endif; ?>
					<?php if ($this->ion_auth->in_group(array('lmedicas180'))): ?>
				        <li class="<?= array('lmedicas180') === array_slice($menu_items, 1, 1) ? 'active' : '' ?>">
			        		<a href="<?= site_url('LicenciasMedicas/licencias180') ?>">
				        		<i class="menu-icon fa fa-stethoscope"></i>
				                <span class="menu-text"> Tope 180 días</span>
			            	</a>
			            	<b class="arrow"></b>
				        </li>
			        <?php endif; ?>
		        <?php endif; ?>
		    </ul>
		</li>
		<?php endif; ?>
        <!-- FIN Menu Licencias Medicas -->
        
        
    <!-- Menu Dias Pedidos Drogueria -->
        <?php if ($this->ion_auth->in_group(array('admin','bpdrogueria'))): ?>
        <li class="<?= array('bpdrogueria') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
        			<a href="<?= site_url('Buscadorprocess/pedidoDrogueria') ?>">
                <i class="menu-icon fa fa-medkit"></i>
                <span class="menu-text"> Pedidos Droguería</span>
            </a>
            <b class="arrow"></b>
        </li> <?php endif; ?><!-- FIN Menu Pedidos Drogueria -->
        
        
        
        <!-- Menu consultor process -->
        <?php if (!$this->ion_auth->in_group(array('juridica1','abogado'))): ?>       <!-- si esta en juridica, lo omite-->
        <li class="<?= array('consultor') === array_slice($menu_items, 0, 1) ? 'active' : '' ?>">
        		<a href="<?= site_url('Buscadorprocess/consultorProcess') ?>">
                <i class="menu-icon fa fa-search"></i>
                <span class="menu-text"> Consultar caso </span>
            </a>
            <b class="arrow"></b>
        </li> <!-- FIN Menu consultorprocess -->
        <?php endif; ?>

        <!-- Menu Utilidades -->
        <?php if (!$this->ion_auth->in_group(array('juridica1','abogado'))): ?>       <!-- si esta en juridica, lo omite-->
        <li class="<?= array('utilidades') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-files-o"></i>
                <span class="menu-text"> Utilidades </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Utilidades: Sub menu Anexos -->
        		<li class="<?= array('utilidades', 'anexos') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
            		<a href="<?= site_url('Anexos') ?>">
                		<i class="menu-icon fa fa-address-book-o"></i>
                		Anexos
            		</a>
        		</li>
				<!-- Menu Utilidades: Sub menu Instructivos -->
				<li class="<?= array('utilidades','instructivos') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            		<a href="<?= site_url('Instructivos') ?>">
                		<i class="menu-icon fa fa-file-text"></i>
                		Instructivos
					</a>
				</li>
				<?php if ($this->ion_auth->in_group('developed')): ?>
				<!-- Menu Utilidades: Sub menu Links -->
				<li class="<?= array('utilidades', 'links') === array_slice($menu_items, 0, 2) ? 'active open' : '' ?>">
                    <a href="#">
                        <i class="menu-icon fa fa-link"></i>
                        Links
                    </a>
                    <b class="arrow"></b>
                </li><?php endif; ?>
            </ul>
        </li> <!-- FIN Menu Utilidades -->
        <?php endif; ?>
        
        <?php if ($this->ion_auth->in_group('developed')): ?>
        <!-- Menu Noticias -->
        <li class="<?= array('noticias') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-newspaper-o"></i>
                <span class="menu-text"> Noticias </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Noticias: Sub menu internas -->
                <li class="<?= array('noticias', 'internas') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
                    <a href="<?= site_url('Noticias/internas') ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Internas
                    </a>
                    <b class="arrow"></b>
                </li> <!-- Menu Noticias: Sub menu internas -->
            </ul>
        </li><?php endif; ?><!-- FIN Menu Noticias -->

        
        <!-- Menu Información/faq/documentación -->
        <li class="<?= array('ayuda') === array_slice($menu_items, 0, 1) ? 'active open' : '' ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-info"></i>
                <span class="menu-text"> Ayuda </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
			<ul class="submenu">
				<!-- Menu Información/faq/documentación: Sub menu Cambios de sistema -->
                <li class="<?= array('ayuda', 'changelog') === array_slice($menu_items, 0, 2) ? 'active' : '' ?>">
                    <a href="<?= site_url('Ayuda') ?>">
                        <i class="menu-icon fa fa-code"></i>
                        Cambios de Sistema
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li> <!-- FIN Menu Información/faq/documentación -->
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-save-state ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
            data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>