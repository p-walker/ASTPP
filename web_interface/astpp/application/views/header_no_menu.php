<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>ASTPP - Open Source Voip Billing Solution</title>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/google_jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.datepicker.js"></script>

	      
	<link href="<?php echo base_url();?>assets/css/ui/ui.base.css" rel="stylesheet" media="all" />
	<link href="<?php echo base_url();?>assets/css/themes/apple_pie/ui.css" rel="stylesheet" title="style" media="all" />
	<link href="<?php echo base_url();?>assets/css/ui/ui.datepicker.css" rel="stylesheet" media="all" />
	<link href="<?php echo base_url();?>assets/css/facebox.css" rel="stylesheet" media="all" />
	<link href="<?php echo base_url();?>assets/css/fg.menu.css" rel="stylesheet" media="all" />
	<link href="<?php echo base_url();?>assets/css/ui/ui.forms.css" rel="stylesheet" media="all" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/astppbilling.css" type="text/css" />
		
	<style>
	    .icon {
	        padding-left: 5px;
	        padding-top: 2px;
	        padding-right: 13px;
	        padding-bottom: 2px;
	        background-repeat:
	        no-repeat;
	    }	
	body {
	    font-size: 62.5%;
	    font-family: 'Segoe UI', Frutiger, Tahoma, Helvetica, 'Helvetica Neue', Arial, sans-serif;
	}	  	  
	</style>
	
	<script type="text/javascript" >	
		$(document).ready(function(){
			
			$('.hasDatepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true
			});	
		});
}
	</script>
	<? start_block_marker('extra_head') ?>
	<? end_block_marker() ?>	
</head>
<body>
<?php 
	$logged_in = $this->session->userdata('user_login');	
	$logged_user = $this->session->userdata('user_name');
?>
<div id="page_wrapper">
