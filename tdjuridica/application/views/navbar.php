<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="<?= base_url('index.php/inicio') ?>" class="navbar-brand">
                <small>
                    <!--  <i class="fa fa-users"></i>  -->
                    <?= $site_navbar_name ?>
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav" style="">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle" aria-expanded="false">
                        <img class="nav-user-photo" src="<?= base_url('assets/images/avatars/logocmv.png') ?>" 
                        							alt="<?= isset($avatar_descrip) ? $avatar_descrip : 'Foto de Usuario' ?>">
                        <span class="user-info">
                            <small>Bienvenido,</small>
                            <?php if ($this->session->userdata('first_name')): ?>
                            	<?=$this->session->userdata('first_name')?>
							<?php endif; ?>
                            <?php if ($this->session->userdata('login_google')): ?>
                            	<?=$this->session->userdata('user_data')['first_name']?>
							<?php endif; ?>
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?= site_url('PerfilUser') ?>">
                                <i class="ace-icon fa fa-user"></i>
                                Perfil
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('PerfilUser/ajustes') ?>">
                                <i class="ace-icon fa fa-cog"></i>
                                Ajustes
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?= site_url('auth/logout') ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>