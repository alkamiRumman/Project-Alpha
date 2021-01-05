<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= SHORTNAME ?> | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="icon" href="<?= base_url('images/icon.png') ?>" type="image/x-icon" />
	<link rel="stylesheet" href="<?= base_url('assets/adminLte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/adminLte/bower_components/font-awesome/css/font-awesome.min.css') ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url('assets/adminLte/bower_components/Ionicons/css/ionicons.min.css') ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/adminLte/dist/css/AdminLTE.min.css') ?>">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?= base_url('assets/adminLte/plugins/iCheck/square/blue.css') ?>">


	<!-- Google Font -->
	<link rel="stylesheet"
		  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="background-image: url('<?= base_url('images/background.jpg') ?>');
		background-repeat: no-repeat; background-size: 100% 100%;">
<div class="modal fade" id="remoteModal1" role="dialog" aria-hidden="true" data-backdrop="static"
	 data-keyboard="false" style="z-index: 999999"></div>
<div class="login-box">
	<div class="login-logo">
		<h3 style="color: white"><b><?= COMPANY ?></b></h3>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">login to start your session</p>
		<form action="<?= login_url('verify') ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" id="email" name="email" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<a onclick="loadPopup('<?= login_url('forgetPassword') ?>')">Forget Password</a><br>
			<a href="<?= login_url('register') ?>">Create an Account</a>
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
		<table class="table table-bordered" style="margin-top:10px">
			<tr id="tab">
				<td>admin@admin.com</td>
				<td>Super Admin</td>
				<td>123</td>
			</tr>
			<tr id="admin">
				<td>admin1@admin.com</td>
				<td>Sub Admin</td>
				<td>123</td>
			</tr>
			<tr id="admin1">
				<td>alkami778@gmail.com</td>
				<td>Sub Admin</td>
				<td>123</td>
			</tr>
			<tr id="member">
				<td>member@admin.com</td>
				<td>Member</td>
				<td>123</td>
			</tr>
		</table>
	</div>
</div>
<?php
	if ($this->session->flashdata('success')) {
?>
<div class="text-center">
	<div class="alert alert-success navbar-fixed-bottom" role="alert">
		<p style="font-size: 15px;"><?php echo $this->session->flashdata('success'); ?></p>
	</div>
	<?php
		}
		if ($this->session->flashdata('danger')) { ?>
			<div class="text-center">
				<div class="alert alert-danger navbar-fixed-bottom" role="alert">
					<p style="font-size: 15px;"><?php echo $this->session->flashdata('danger'); ?></p>
				</div>
			</div>
		<?php } ?>
</div>
<script src="<?= base_url('assets/adminLte/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminLte/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/adminLte/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
	function loadPopup(url) {
		$("#remoteModal1").load(url, function (e) {
			setTimeout(function (e) {
				$("#remoteModal1").modal('show');
			});
		});
	}
	setTimeout(function () {
		$('.alert').hide('fast');
	}, 3000);

	$(function () {
		$('#tab').on('click', function(){
			$('#email').val('admin@admin.com');
			$('#password').val('123');
		})
		$('#admin').on('click', function(){
			$('#email').val('admin1@admin.com');
			$('#password').val('123');
		})
		$('#admin1').on('click', function(){
			$('#email').val('alkami778@gmail.com');
			$('#password').val('123');
		})
		$('#member').on('click', function(){
			$('#email').val('member@admin.com');
			$('#password').val('123');
		})

		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' /* optional */
		});
	});
</script>
</body>
</html>
