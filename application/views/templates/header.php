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
  		<!-- Brand -->
  		

	  	<!-- Toggler/collapsibe Button -->
	  	<!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"></button>-->
	  	<a class="navbar-brand" href="#">DGUV3</a>
	    	<!--<span class="navbar-toggler-icon"></span>-->
  		</button>

	  	<!-- Navbar links -->
	  	<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
                        <li class="nav-item">
	        		<a class="nav-link" href="<?php echo site_url('geraete'); ?>"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</a>
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


	<div class="container-fluid" style="width:95%">