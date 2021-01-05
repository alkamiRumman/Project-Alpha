<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<!-- Logo -->
		<a href="" class="logo" style="background-color: #b3cde0">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini" style="color: black"><b><?= SHORTNAME ?></b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg" style="color: black"><b><?= getUserType() ?> </b><?= SHORTNAME ?></span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" style="background-color: #b3cde0">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>

			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">

					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
						<a href="<?= dashboard_url('index') ?>" class="dropdown-toggle" data-toggle="dropdown">
							<b style="color: black"><?= COMPANY ?></b>
						</a>
					</li>
					<li class="dropdown user user-menu">
						<a style="color: black" href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?= getSession()->profilePicture ? base_url('images/' . getSession()->id . '/' . getSession()->profilePicture)
									: base_url('assets/adminLte/dist/img/noImage.png') ?>" class="user-image"
								 alt="User Image">
							<span style="color: black" class="hidden-xs"><?= getSession()->name ?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="user-header" style="background-color: #b3cde0">
								<img src="<?= getSession()->profilePicture ? base_url('images/' . getSession()->id . '/' . getSession()->profilePicture)
										: base_url('assets/adminLte/dist/img/noImage.png') ?>" class="img-circle"
									 alt="User Image">
								<p style="color: black">
									<?= getSession()->name ?>
									<small>Joined Since - <?= date('d F Y', strtotime(getSession()->createAt)) ?></small>
								</p>
							</li>
							<li class="user-footer">
								<div class="pull-left">
									<a onclick="loadPopup('<?= login_url('profile') ?>')" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a href="<?= login_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar" style="background-color: #03396c">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?= getSession()->profilePicture ? base_url('images/' . getSession()->id . '/' . getSession()->profilePicture)
							: base_url('assets/adminLte/dist/img/noImage.png') ?>" style="border-radius: 50%;" class="user-image" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><?= getSession()->name ?></p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<div class="sideMenu">
				<ul class="sidebar-menu" data-widget="tree">
					<?php if (isSuperAdmin()) { ?>
						<li>
							<a href="<?= dashboard_url('index') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
						<li>
							<a href="<?= dashboard_url('users') ?>"><i class="fa fa-users"></i> <span>Users</span>
							</a>
						</li>
						<li>
							<a href="<?= dashboard_url('dormitory') ?>"><i class="fa fa-hotel"></i> <span>Dormitory</span>
							</a>
						</li>
						<li>
							<a href="<?= dashboard_url('companyList') ?>"><i class="fa fa-home"></i> <span>Company List</span>
							</a>
						</li>
						<li>
							<a href="<?= dashboard_url('workerDetails') ?>"><i class="fa fa-gears"></i> <span>Worker Details</span>
							</a>
						</li>
						<!--						<li class="treeview">-->
						<!--							<a href="treeview-menu">-->
						<!--								<i class="fa fa-home"></i>-->
						<!--								<span>Company Profile</span>-->
						<!--								<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>-->
						<!--							</a>-->
						<!--							<ul class="treeview-menu">-->
						<!--								<li><a href="--><?//= dashboard_url('addCompany') ?><!--"><i class="fa fa-plus-circle"></i> Add Company</a></li>-->
						<!--								<li><a href="--><?//= dashboard_url('companyList') ?><!--"><i class="fa fa-list-ul"></i> Company List</a></li>-->
						<!--							</ul>-->
						<!--						</li>-->
					<?php }
						if (isAdmin()) { ?>
							<li>
								<a href="<?= home_url('index') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
								</a>
							</li>
							<li>
								<a href="<?= home_url('dormitory') ?>"><i class="fa fa-hotel"></i> <span>Dormitory</span>
								</a>
							</li>
							<li>
								<a href="<?= home_url('companyList') ?>"><i class="fa fa-home"></i> <span>Company List</span>
								</a>
							</li>
							<li>
								<a href="<?= home_url('workerDetails') ?>"><i class="fa fa-gears"></i> <span>Worker Details</span>
								</a>
							</li>
							<!--							<li class="treeview">-->
							<!--								<a href="treeview-menu">-->
							<!--									<i class="fa fa-home"></i>-->
							<!--									<span>Company Profile</span>-->
							<!--									<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>-->
							<!--								</a>-->
							<!--								<ul class="treeview-menu">-->
							<!--									<li><a href="--><?//= home_url('addCompany') ?><!--"><i class="fa fa-plus-circle"></i> Add Company</a></li>-->
							<!--									<li><a href="--><?//= home_url('companyList') ?><!--"><i class="fa fa-list-ul"></i> Company List</a></li>-->
							<!--								</ul>-->
							<!--							</li>-->
						<?php }
						if (isMember()) { ?>
							<li>
								<a href="<?= member_url('index') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
								</a>
							</li>
							<li class="treeview">
								<a href="treeview-menu">
									<i class="fa fa-home"></i>
									<span>Company Profile</span>
									<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
								</a>
								<ul class="treeview-menu">
									<li><a href="<?= member_url('addCompany') ?>"><i class="fa fa-plus-circle"></i> Add Company</a></li>
									<li><a href="<?= member_url('companyList') ?>"><i class="fa fa-list-ul"></i> Company List</a></li>
								</ul>
							</li>
							<li>
								<a href="<?= member_url('workerDetails') ?>"><i class="fa fa-gears"></i> <span>Worker Details</span>
								</a>
							</li>
						<?php } ?>
					?>
				</ul>
			</div>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<?php
				if ($this->session->flashdata('success')) {
					?>
					<div class="text-center alert alert-success" role="alert">
						<p style="font-size: 20px">
							<?php echo $this->session->flashdata('success'); ?></p>
					</div>
					<?php
				}
				if ($this->session->flashdata('danger')) {
					?>
					<div class="alert alert-danger text-center" role="alert">
						<p style="font-size: 20px">
							<?php echo $this->session->flashdata('danger'); ?></p>
					</div>
				<?php } ?>

			<script>
				$(function () {
					var url = window.location;
					// Will only work if string in href matches with location
					$('.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
					// Will also work for relative and absolute hrefs
					$('.treeview-menu li a').filter(function () {
						return this.href == url;
					}).parent().parent().parent().addClass('active', 'text-danger');
				});
			</script>
