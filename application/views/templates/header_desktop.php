<!DOCTYPE html>
<html>
<head>
<?php if(isset($title) && $title) { ?>
<title><?php echo $title; ?></title>
<?php } ?>
	<meta charset="UTF-8">
	<script src="<?php echo base_url();?>lib/jquery/jquery-3.6.0.min.js"></script>
	<script src="<?php echo base_url();?>lib/jquery/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>lib/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>lib/datatables/datatables.js"></script>
	<!--<script src="<?php echo base_url();?>lib/datatables/datatables.min.js"></script>-->
	<!--<script src="<?php echo base_url();?>lib/datatables/jquery.dataTables.min.js"></script>-->
	<script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>
	<!-- <script defer src="<?php echo base_url();?>lib/navbar.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>

  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap"
    rel="stylesheet"
  />

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/jquery/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/jquery/jquery-ui.structure.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/jquery/jquery-ui.theme.min.css">
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/datatables/datatables.min.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>lib/datatables/datatables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/dguv3.css">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.css">


<link rel="shortcut icon" href="/favicon.ico">
</head>

<body>



<nav class="navbar sticky-top navbar-expand-xl bg-dark navbar-dark">
  <a class="navbar-brand" href="<?php echo site_url('Dguv3'); ?>">DGUV3
	<?php if(isset($cronjobs) && $cronjobs) { ?>

	<span class="badge badge-danger"><?php echo $cronjobs; ?></span>
	<?php } ?></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">




      <li class="nav-item">
        			<a class="nav-link" href="<?php echo site_url('geraete'); ?>"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Gerät</a>
      			</li>
	      		<li class="nav-item">
        			<a class="nav-link" href="<?php echo site_url('orte'); ?>"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Orte</a>
      			</li>
      			<li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('pruefer'); ?>"><span class="iconify" data-icon="ic:baseline-account-circle" data-width="20" data-height="20"></span> Prüfer</a>
      			</li>
                        <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('messgeraete'); ?>"><span class="iconify" data-icon="ic:outline-computer" data-width="20" data-height="20"></span> Messgeräte</a>
      			</li>
                        <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('pruefung'); ?>"><span class="iconify" data-icon="bx:bx-clipboard" data-width="20" data-height="20"></span> Prüfungen</a>
      			</li>
				  <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('firmen'); ?>"><span class="iconify" data-icon="bx:bxs-business" data-width="20" data-height="20"></span> Firmen</a>
      			</li>
				  <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('users'); ?>"><span class="iconify" data-icon="fa-solid:users" data-width="20" data-height="20"></span> User</a>
      			</li>
				  <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('log'); ?>"><span class="iconify" data-icon="carbon:catalog" data-width="20" data-height="20"></span> Logs</a>
      			</li>

    </ul>
    <ul class="nav navbar-nav navbar-right">
	<div class="d-flex align-items-center">
    	<?php if($this->session->userdata('level')) {
			if($this->session->userdata('level')==1) {
				$userroll='admin';
			} elseif($this->session->userdata('level')==2) {
				$userroll='Prüfer';
			} elseif($this->session->userdata('level')==3) {
				$userroll='Verwaltung';
			} else {
				$userroll='User';
			}

			?>


		<a class="nav-link" href="<?php echo site_url('users/index/');?><?php echo $this->session->userdata('userid');?>"><?php echo $this->session->userdata('username');?> (<?php echo $userroll;?>)</a>



      <li class="nav-item"> <a class="nav-link" href="<?php echo site_url('login/logout');?>"><span class="iconify" data-icon="mdi:logout" data-width="20" data-height="20"></span> Logout</a></li>

    <?php } else { ?>
     <li class="nav-item"><a class="nav-link" href="<?php echo site_url('login');?>"><span class="iconify" data-icon="mdi:logout" data-width="20" data-height="20"></span> Login</a></li>
    <?php } ?>
	</div>
    </ul>

</nav>




<!--; border: 1px solid #000;-->

	<div class="container-fluid" style="width:95%">
