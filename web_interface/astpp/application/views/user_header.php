<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>ASTPP - Open Source Voip Billing Solution</title>
    <script language="javascript" type="text/javascript">
	  var base_url = '<?php echo base_url();?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.7.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/flexigrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.core.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.widget.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.mouse.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/live_search.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/tooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.sortable.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.draggable.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.resizable.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.position.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.button.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/ui/ui.dialog.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/fg.menu.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/facebox.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/popup_search.js"></script>
	
    <link href="<?php echo base_url();?>assets/css/ui/ui.base.css" rel="stylesheet" media="all" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/flexigrid.css" type="text/css">
    <link href="<?php echo base_url();?>assets/css/themes/apple_pie/ui.css" rel="stylesheet" title="style" media="all" />
    <link href="<?php echo base_url();?>assets/css/themes/apple_pie/ui.css" rel="stylesheet" media="all" />
    <link href="<?php echo base_url();?>assets/css/ui/ui.datepicker.css" rel="stylesheet" media="all" />
    <link href="<?php echo base_url();?>assets/css/facebox.css" rel="stylesheet" media="all" />
    <link href="<?php echo base_url();?>assets/css/fg.menu.css" rel="stylesheet" media="all" />	
    <link href="<?php echo base_url();?>assets/css/ui/ui.forms.css" rel="stylesheet" media="all" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/astppbilling.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/menu.css" type="text/css" media="screen" />
    <? start_block_marker('extra_head') ?>
    <? end_block_marker() ?>
</head>
<body>
<?php 
	$logged_in = $this->session->userdata('user_login');	
	$logged_user = $this->session->userdata('user_name');
	
	$menu_no = 1;
	if(isset($cur_menu_no)) $menu_no = $cur_menu_no;
	$submenu_no = 1;
	if(isset($cur_submenu_no)) $submenu_no = $cur_menu_no;
	
?>
	<div id="page_wrapper">
		<div id="page-header">
			<div id="page-header-wrapper" style="height: 140px;">            
				<div id="top" style="height: 78px;" onmouseover="hide_sub()">
					<a href="<?=base_url()?>user/dashboard" class="logo" title="<?=$app_name?>" ><?=$app_name?></a>
					<?php if($logged_in==TRUE):?>
					<div class="welcome">
						<span class="note" style="color: black;">Welcome <a href="#" title="Welcome <?=$logged_user?>"><?=ucfirst($logged_user)?><? //echo $this->session->userdata('logintype').$this->session->userdata('mode_cur');?></a></span>
						
						<?php if($this->session->userdata('username') != ""){?>
						    <a class="btn ui-state-default ui-corner-all" href="<?=base_url()?>user/accountsdetail/<?=$this->session->userdata('username')?>">
							    <span class="ui-icon ui-icon-person"></span>
							    My account
						    </a>
						<?php }?>
						    <a class="btn ui-state-default ui-corner-all" href="<?php echo base_url();?>astpp/logout" style="background-color: transparent;">
							<span class="ui-icon ui-icon-power"></span>
							Logout
						</a>						
					</div>
					<?php endif;?>
				</div>
				<?php if($logged_in==TRUE):?>
				<div  style="height: 34px; left: 0;   padding-top: 10px;   position: absolute;   top: 38px; width: 100%;">

				<ul id="menu">                    
				<li style="-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;"><a href="<?php echo base_url();?>user/dashboard"><img src="<?=base_url()?>assets/images/menu_icons/Home.png" border="0" width="16" height="16"  />&nbsp;&nbsp;Home</a>                       
				</li>
				<li><a href="#" class="drop_menu">Accounts</a>                    
				<div class="dropdown_2columns">                    
				<div class="col_1">                    
				    <ul class="simple">
					<li><a href="<?php echo base_url();?>user/accountsdetail"><img src="<?=base_url()?>assets/images/menu_icons/Accounts/ListAccounts.png" border="0" width="16" height="16" />&nbsp;&nbsp;Accounts Detail</a></li>
					<li><a href="<?php echo base_url();?>user/user_invoice_list"><img src="<?=base_url()?>assets/images/menu_icons/Accounts/InvoiceList.png" border="0" width="16" height="16" />&nbsp;&nbsp;Invoice Detail</a></li>
					<li><a href="<?php echo base_url();?>userReports/myReport/"><img src="<?=base_url()?>assets/images/menu_icons/CDR/cdr.png" border="0" width="16" 	height="16" />&nbsp;&nbsp;My Account CDR</a></li>                           
					<li><a href="<?php echo base_url();?>user/user_payment_list"><img src="<?=base_url()?>assets/images/menu_icons/Accounts/InvoiceList.png" border="0" width="16" height="16" />&nbsp;&nbsp;Payment Detail</a></li>
				    </ul>                            
				</div>                    
				</div>                    
				</li>                    
				<li>
				<a href="#" class="drop_menu">Services</a>
				
				<div class="dropdown_2columns">
				<div class="col_1">            
				<h3>Calling Cards</h3>
				<ul class="simple">
					
					<li><a href="<?php echo base_url();?>user/cclist"><img src="<?=base_url()?>assets/images/menu_icons/Modules/CallingCards/CallingCardCDR's.png" border="0" width="16" height="16" />&nbsp;&nbsp;My Callingcard</a></li> 
					<li><a href="<?php echo base_url();?>userReports/myccReport"><img src="<?=base_url()?>assets/images/menu_icons/CDR/cdr.png" border="0" width="16" height="16" />&nbsp;&nbsp;My Callingcard CDR</a></li> 
				      
				    </ul>                      
				</div>            
				
				</div>                   
				</li>                  
				<li>
				<a href="#" class="drop_menu">DIDs</a>
				<div class="dropdown_2columns">                    
				<div class="col_1">                   
				    <ul class="simple">
					<li><a href="<?php echo base_url();?>user/didslist"><img src="<?=base_url()?>assets/images/menu_icons/DID's/ManageDIDs.png" border="0" width="16" height="16" />&nbsp;&nbsp;Manage DID's</a></li>
				      
				    </ul>                         
				</div>
				
				</div>                      
				</li>
				<li><a href="#" class="drop_menu">Mapping</a>
				<div class="dropdown_2columns">
				<div class="col_1">            
				<ul class="simple">
				      <li><a href="<?php echo base_url();?>useranimapping/animappinglists"><img src="<?=base_url()?>assets/images/menu_icons/LCR/Providers.png" border="0" width="16" height="16" />&nbsp;&nbsp;ANI Mapping</a></li>                         
				    </ul>                     
				</div>                				
				</div>
				</li>                   
				
				<li><a href="#" class="drop_menu">Rates</a>
				<div class="dropdown_2columns">
				<div class="col_1">            
				<ul class="simple">
				      <li><a href="<?php echo base_url();?>user/rates"><img src="<?=base_url()?>assets/images/menu_icons/LCR/OutboundRoutes.png" border="0" width="16" height="16" />&nbsp;&nbsp;Rates</a></li>                         
				    </ul>                     
				</div>                
				
				</div>
				</li>                   

				</li>                    
				</ul>

					    </div>
	    
					    <?php endif;?>
				    </div>
			    </div>
