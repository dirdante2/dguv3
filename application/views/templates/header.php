<!DOCTYPTE html>
<html>
<head>

	<meta charset="utf-8">
	<script src="<?php echo base_url();?>lib/jquery/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url();?>lib/jquery/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>lib/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>lib/datatables/datatables.js"></script>
	<!--<script src="<?php echo base_url();?>lib/datatables/datatables.min.js"></script>-->
	<!--<script src="<?php echo base_url();?>lib/datatables/jquery.dataTables.min.js"></script>-->
	<script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>
	<script defer src="<?php echo base_url();?>lib/jquery/navbar.js"></script>
	
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
</head>


<body>
 	


<nav class="navbar sticky-top navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#">DGUV3</a>
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
	        		<a class="nav-link" href="<?php echo site_url('pruefung'); ?>"><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> Prüfungen</a>
      			</li>
    </ul>
    
  </div>
</nav>




<!--; border: 1px solid #000;-->

	<div class="container-fluid" style="width:95%">