<html>

<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
</style>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <title>Inicio de Sesión - Plataforma de Reemplazos</title>

    <meta name="description" content="Inicio de Sesión - Plataforma de Transformación Digital">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome/4.5.0/css/font-awesome.min.css') ?>">

    <!-- text fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/css/fonts.googleapis.com.css') ?>">

    <!-- ace styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/ace.min.css') ?>">

    <!--[if lte IE 9]>
			<link rel="stylesheet" href="<?= base_url('assets/css/ace-part2.min.css') ?>" />
		<![endif]-->
    <link rel="stylesheet" href="<?= base_url('assets/css/ace-rtl.min.css') ?>">

    <!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?= base_url('assets/css/ace-ie.min.') ?>" />
		<![endif]-->

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
		<script src="<?= base_url('assets/js/html5shiv.min.js') ?>"></script>
		<script src="<?= base_url('assets/js/respond.min.js') ?>"></script>
		<![endif]-->
</head>

<body class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                        	
                            <h2>
                            	<img src="<?= base_url('assets/images/view/login/logocmv.png') ?>" height="35px" alt="Logo CMV" />
                                <!-- ><i class="ace-icon fa fa-group green"></i><!-->
                                
                                <span class="grey" id="id-text2">
                                    <?= $site_title ?></span>
                            </h2>
                            <h4 class="blue" id="id-company-text"><?= $company_name ?></h4>
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h2 class="text-center grey">
                                            <?= lang('login_heading'); ?>
                                        </h2>
                                        
                                        <div class="space-6"></div>
                                        
                                        <h4 class="header blue lighter bigger text-center">
                                            <i class="ace-icon fa fa-coffee green"></i>
                                            <?= lang('login_subheading'); ?>
                                        </h4>

                                        <div class="space-6"></div>
                                        
                                        <?php if(!empty($message)): ?>
                                        <?= $message; ?>
										<?php endif; ?>
                                        <?= form_open("auth/login");?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <?= lang('login_identity_label', 'identity'); ?>
                                                <span class="block input-icon input-icon-right">
                                                    <?= form_input($identity);?>
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <?= lang('login_password_label', 'password');?>
                                                <span class="block input-icon input-icon-right">
                                                    <?= form_input($password);?>
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <?= form_checkbox('remember', '1', FALSE, 'id="remember" class="ace"'); ?>
        											<span class="lbl"><?= lang('login_remember_label', 'remember'); ?></span>
                                                </label>

                                                <input type="submit" name="submit" value="<?= lang('login_submit_btn') ?>" class="width-35 pull-right btn btn-sm btn-primary">
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                        </form>
                                    </div><!-- /.widget-main -->
                                    
                                    <div class="toolbar clearfix">
                                        <div style="width:100%; text-align: center!important;">
                                            <a href="<?= site_url('googleAuth/logincmv') ?>" style="color:white;">
                                            	<i class="ace-icon fa fa-google"></i>
                                                Ingresar con correo Institucional 
                                            </a>
                                        </div>
                                    </div>

                                    <div class="toolbar clearfix">
                                        <div style="width:100%; text-align: center!important;">
                                            <a href="<?= site_url('auth/forgot_password') ?>" class="forgot-password-link">
                                                <?= lang('login_forgot_password'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->
                        </div><!-- /.position-relative -->
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?= base_url('assets/js/jquery-2.1.4.min.js') ?>"></script>

    <!-- <![endif]-->

    <!--[if IE]>
	<script src="<?= site_url('assets/js/jquery-1.11.3.min.js') ?>"></script>
	<![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url('assets/js/jquery.mobile.custom.min.js') ?>'>" + "<" + "/script>");
    </script>
</body>

</html>