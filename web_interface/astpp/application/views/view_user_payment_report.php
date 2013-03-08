<? extend('user_master.php') ?>

	<? startblock('extra_head') ?>
<script type="text/javascript" language="javascript">
function get_alert_msg(id)
{
    confirm_string = 'are you sure to delete?';
    var answer = confirm(confirm_string);
    return answer // answer is a boolean
}
</script>

<script type="text/javascript">
$(document).ready(function() {
	var showOrHide=false;
	$("#search_bar").toggle(showOrHide);
	
$("#flex1").flexigrid({
    url: "<?php echo base_url();?>user/pyament_report_list/",
    method: 'GET',
    dataType: 'json',
	colModel : [
		{display: 'Amount', name: 'amount',width:100, sortable: false, align: 'center'},	
		{display: 'Payment Type', name: 'paymentby',width:120, sortable: false, align: 'center'},
		{display: 'Notes', name: 'notes',width:100, sortable: false, align: 'center'},			
		{display: 'Reference', name: 'ReferenceBY',width:100, sortable: false, align: 'center'},			
	],
	buttons : [
		{name: 'Remove Search Filter', bclass: 'reload', onpress : clear_filter},
	],
	nowrap: false,
	showToggleBtn: false,
	sortname: "Payment Details",
	sortorder: "asc",
	usepager: true,
	resizable: true,
	title: '',
	useRp: true,
	rp: 20,
	showTableToggleBtn: false,
	height: "auto",	
	width: "auto",	
	pagetext: 'Page',
	outof: 'of',
	nomsg: 'No items',
	procmsg: 'Processing, please wait ...',
	pagestat: 'Displaying {from} to {to} of {total} items',
	onSuccess: function(data){
        //alert(data);
        //format();
	},
	onError: function(){
	  alert("Request failed");
      }
});
    $("#payment_search").click(function(){	

	$.ajax({
	  type:'POST',
	  url: '<?=base_url()?>user/payment_search',
	  data:$('#payment_form').serialize(),
	  success: function(response) {
	    $('#flex1').flexReload();
	  }
	});
    });
	
    $("#id_reset").click(function(){
	    $.ajax({url:'<?=base_url()?>user/clearsearchfilter_payment/',
	    success:function(){
		$('#flex1').flexReload(); }
	    });
    });
	
    $("#show_search").click(function(){
      $("#search_bar").toggle();
    });

});

function clear_filter()
{
	window.location = '<?php echo base_url();?>user/clearsearchfilter_payment/';
}
function reload_button()
{
    $('#flex1').flexReload();
}

</script>	

<style>
    fieldset{
        text-align: center;
        
    }
</style>
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
    <? startblock('content') ?>  

	    <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="searchbar">                        
	      <div class="portlet-header ui-widget-header"><span id="show_search" style="cursor:pointer">Search</span><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
	    </div>
	    <div class="portlet-content"  id="search_bar">           
	         <form action="<?=base_url()?>rates/routes_search" id="payment_form" name="payment_form" method="POST" enctype="multipart/form-data" style="display:block">
		  <input type="hidden" name="ajax_search" value="1">
		  <input type="hidden" name="advance_search" value="1">
		      <ul style="list-style:none;">
			<fieldset >
			  <legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Payments</span></legend>
			  <li>
			      <div class="float-left" style="width:30%">
				    <span>
				      <label>Amount :</label>
				      <input size="20" class="text field" name="amount"> &nbsp;
				      <select name="amount_operator" class="field select" style="width:132px;">
				      <option value="1">is equal to</option>
				      <option value="2">is not equal to</option>
				      <option value="3">greater than</option>
				      <option value="4">less than</option>
				      <option value="5">greather or equal than</option>
				      <option value="6">less or equal than</option>
				      </select>
				    </span>
			      </div>
			      <div class="float-left" style="width:30%">
				  <span>
				    <label>Payment Type :</label>
				      <select name="payment_type" id="payment">
					<option value="">-- ALL --</option>
				      <?php foreach($payment_type as $payment_key =>$payment_value){ ?>
					  <option value="<?=$payment_key?>"><?=$payment_value?></option>
				      <?}?>
				      </select>
				  </span>
			      </div>
			</fieldset> <br />
			    <input type="reset" id="id_reset" class="ui-state-default float-right ui-corner-all ui-button" name="reset" value="Clear Search Filter">&nbsp;   
			    <input type="button" class="ui-state-default float-right ui-corner-all ui-button" name="action" value="Search" id="payment_search" style="margin-right:22px;" />
			  <br><br>  
			</ul>
		</form>             
          </div>
	  <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
	      <div class="portlet-header ui-widget-header">Payment Detail Report<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
	      <div class="portlet-content">         
		  <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">
		      <table id="flex1" align="left" style="display:none;"></table>
		  </form>
	      </div>
	  </div>  
    <? endblock() ?>	

    <? startblock('sidebar') ?>
	  <ul id="navigation">
		  <li><a href="<?php echo base_url();?>accounts/create/">Create Account</a></li>
		  <li><a href="<?php echo base_url();?>accounts/account_list/">List Accounts</a></li>							
	  </ul>
	  <br/><br/><br/><br/><br/><br/>    	
    <? endblock() ?>
    
<? end_extend() ?>  
 
 
