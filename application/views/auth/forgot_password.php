<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <title>Inicio de Sesión - Plataforma de Reemplazos</title>

    <meta name="description" content="Inicio de Sesión - Plataforma de Reemplazos">
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
                                <i class="ace-icon fa fa-group green"></i>
                                <span class="grey" id="id-text2">
                                    <?= $site_title ?></span>
                            </h2>
                            <h4 class="blue" id="id-company-text">
                                <?= $company_name ?>
                            </h4>
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="forgot-box" class="forgot-box widget-box no-border visible">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-key"></i>
                                            <?= lang('forgot_password_heading'); ?>
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                            <?= sprintf(lang('forgot_password_subheading'), $identity_label); ?>
                                        </p>
                                        
                                        <?php if(!empty($message)): ?>
                                        <?= $message; ?>
										<?php endif; ?>

                                        <?= form_open("auth/forgot_password") ?>
                                            <fieldset>
                                                <label class="block clearfix">
                                                	<?= (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); ?>
                                                    <span class="block input-icon input-icon-right">
                                                        <?= form_input($identity); ?>
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <div class="clearfix">
													<input type="submit" name="submit" value="<?= lang('forgot_password_submit_btn'); ?>" class="width-35 pull-right btn btn-sm btn-primary">
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar center">
                                        <a href="<?= site_url('auth/login') ?>" class="back-to-login-link">
                                            Volver a Inicio de Sesión
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div>
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