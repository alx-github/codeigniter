<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>フォーム投稿管理システム</title>
		
		<!-- Bootstrap -->
		<link href="<?= base_url('assets/umi/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/umi/css/jquery-ui.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/umi/css/jquery.timepicker.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/umi/css/jquery-ui-timepicker-addon.min.css'); ?>" rel="stylesheet">
		<link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="<?= base_url('assets/libs/html5shiv.min.js'); ?>"></script>
		<script src="<?= base_url('assets/libs/respond.min.js'); ?>"></script>
		<![endif]-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?= base_url('assets/libs/jquery.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/account.js'); ?>"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?= base_url('assets/umi/js/bootstrap.min.js'); ?>"></script>
		<script src="<?= base_url('assets/umi/js/jquery-ui.min.js'); ?>"></script>
		<script src="<?= base_url('assets/umi/js/datepicker-ja.js'); ?>"></script>
		<script src="<?= base_url('assets/umi/js/jquery.timepicker.min.js'); ?>"></script>
		<script src="<?= base_url('assets/umi/js/jquery-ui-timepicker-addon.min.js'); ?>"></script>
		<script src="<?= base_url('assets/umi/js/jquery-ui-timepicker-ja.js'); ?>"></script>
		<style type="text/css">
		</style>
	</head>
</head>
<body>




<?php 
	if($this->session->has_userdata('login_id')):
	 ?>
		<nav class="navbar navbar-default" >
		<div class="container-fluid">
			<ul class="navbar-nav nav">
		  	<?php if($current == 'account'): ?>
		  		<li class="active" role="presentation"><a href="<?= site_url('/account') ?>">アカウント管理 </a></li>
		  	<?php else: ?>
		    	<li class="passive-menu"><a href="<?= site_url('/account') ?>">アカウント管理 </a></li>
			<?php endif; ?>

			<?php if($current == 'brand'): ?>
		  		<li class="active"><a href="<?= site_url('') ?>">アカウ</a></li>
		  	<?php else: ?>
		    	<li><a href="<?= site_url('') ?>">アカウ</a></li>
			<?php endif; ?>	

		  	</ul>
		  <ul  class="navbar-nav nav navbar-right">
		  	<li class="passive-menu">
				<a  href="<?= site_url('/auth/logout') ?>">Logout</a>
			</li>
		  </ul>
		</div>
		  
		</nav>	
		

<?php endif; ?>
