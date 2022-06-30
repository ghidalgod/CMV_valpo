<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?= $site_header_title ?></title>

		<meta name="description" content="<?= $site_header_description ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
		<!-- <link rel="stylesheet" href="<?= base_url('assets/font-awesome/4.5.0/css/font-awesome.min.css') ?>" /> -->
		<link rel="stylesheet" href="<?= base_url('assets/font-awesome/4.7.0/css/font-awesome.min.css') ?>" />
		
		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.custom.min.css') ?>" />
		<!--
			##################
			# Component: CSS #
			##################
		-->
		<?= $components->css ?>


		<!-- text fonts -->
		
		<style>
    		@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
		</style>
		
		<!-- ace styles -->
		<link rel="stylesheet" href="<?= base_url('assets/css/ace.min.css') ?>" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?= base_url('assets/css/ace-skins.min.css') ?>" />
		<link rel="stylesheet" href="<?= base_url('assets/css/ace-rtl.min.css') ?>" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?= base_url('assets/js/ace-extra.min.js') ?>"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?= base_url('assets/js/html5shiv.min.js') ?>"></script>
		<script src="<?= base_url('assets/js/respond.min.js') ?>"></script>
		<![endif]-->

	</head>
	<body class='no-skin'>
		<!--
			##########
			# Navbar #
			##########
		-->
		<?= $components->navbar ?>
		
		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<!-- 
				###########
				# Sidebar #
				###########	
			-->
			<?= $components->sidebar ?>

			<div class="main-content">
				<div class="main-content-inner">
					<!-- 
						##############
						# Breadcrumb #
						##############	
					-->
					<?= $components->breadcrumb ?>

					<div class="page-content">
						<!-- /.ace-settings-container -->
						
						<?= $components->pageheader ?>

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<!--
									######################
									# Component: Content # 
									###################### 
									
								
								-->
								<?= $components->content ?>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<!-- 
				##########
				# Footer #
				##########
			-->
			<?= $components->footer ?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>
		
		<!--
			###########
			# Scripts #
			###########
		-->
		<!--[if !IE]> -->
		<script src="<?= base_url('assets/js/jquery-2.1.4.min.js') ?>"></script>
		<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="<?= base_url('assets/js/jquery-2.1.4.min.js') ?>"></script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url('assets/js/jquery.mobile.custom.min.js') ?>'>"+"<"+"/script>");
		</script>
		<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?= base_url('assets/js/excanvas.min.js') ?>"></script>
		<![endif]-->
		<script src="<?= base_url('assets/js/jquery-ui.custom.min.js') ?>"></script>
		<script src="<?= base_url('assets/js/jquery.ui.touch-punch.min.js') ?>"></script>

		<!-- ace scripts -->
		<script src="<?= base_url('assets/js/ace-elements.min.js') ?>"></script>
		<script src="<?= base_url('assets/js/ace.min.js') ?>"></script>
		<!--
			######################
			# Component: Scripts #
			######################
		-->
		<?= $components->script ?>
	</body>
</html>