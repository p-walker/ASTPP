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
$("#flex1").flexigrid({
    url: "<?php echo base_url();?>user/userinvoice_json/",
    method: 'GET',
    dataType: 'json',
	colModel : [
        {display: 'Invoice Numebr', name: 'invoiceid', width: 80, sortable: false, align: 'center'},
        {display: 'Invoice Date', name: 'date', width: 80, sortable: false, align: 'center'},
        {display: 'Invoice Total', name: 'value', width: 100, sortable: false, align: 'center'},
        {display: 'Action', name: '', width : 50, align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, },

		],
    buttons : [
//		{name: 'Add', bclass: 'add', onpress : add_button},
//		{separator: true},
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		{separator: true},
		{name: 'Remove Search Filter', bclass: 'reload', onpress : clear_filter},
		],
	nowrap: false,
			
	showToggleBtn: false,
        sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: true,
	useRp: true,
	rp: 20,
	showTableToggleBtn: false,
	width: "auto",
	height: "auto",	
        pagetext: 'Page',
        outof: 'of',
        nomsg: 'No items',
         procmsg: 'Processing, please wait ...',
        pagestat: 'Displaying {from} to {to} of {total} items',
        
    //preProcess: formatContactResults,
    onSuccess: function(data){
        $('a[rel*=facebox]').facebox({
        	loadingImage : '<?php echo base_url();?>/images/loading.gif',
        	closeImage   : '<?php echo base_url();?>/images/closelabel.png'
      	});
    },
    onError: function(){
        alert("Request failed");
    }
    
});

//$("#from_date").datetimepicker({ dateFormat: 'yy-mm-dd' });

$("#invoice_search").click(function(){

	$.ajax({type:'POST', url: '<? echo base_url()?>user/search',
            data:$('#search_form1').serialize(),
            success: function(response) {
                $('#flex1').flexReload();
                }
       });
  });
  
 $("#id_reset").click(function(){
 
 window.location = '<?php echo base_url();?>user/clearsearchfilter/';
//	$.ajax({url:'<?=base_url()?>accounting/clearsearchfilter', success:function(){
//	$('#flex1').flexReload();	
//	}
//	});
	//$("#id_account").val('');
	//$("#id_company").val('');
	//$("#id_fname").val('');
	//$("#id_lname").val('');
});



});

function clear_filter()
{
	window.location = '<?php echo base_url();?>user/clearsearchfilter/';
}
function delete_button()
{
    if( confirm("are you sure to delete?") == true)
	return true;
	else
	return false;
}
function reload_button()
{
    $('#flex1').flexReload();
}

</script>			
		
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
<br/>

<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="searchbar">                        
    <div class="portlet-header ui-widget-header">Search<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
    <div class="portlet-content">
        <?php
        error_reporting(~E_NOTICE);
        $user_invoice_search = $this->session->userdata('user_invoice_search');
        ?>
        <form action="<?= base_url() ?>user/search" id="search_form1" name="search_form" method="POST" enctype="multipart/form-data" style="display:block" class="form">
            <input type="hidden" name="ajax_search" value="1">
            <input type="hidden" name="advance_search" value="1">
            <ul>
                <fieldset  >
                    <legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Account</span></legend>
                    <li> 
                      <div class="float-left" style="width:400px;">
                         <span>
                               <label>Invoice Number:</label>
                               <input size="20" class="text field" name="invoice_number" value="<?=@$user_invoice_search['invoice_number']?>" > &nbsp;
                               <select name="inumber_operator" class="field select" style="width:132px;" >
                               <option value="1" <?php if(@$user_invoice_search['inumber_operator']==1) { echo "selected";}?> >is equal to</option>
                               <option value="2"  <?php if(@$user_invoice_search['inumber_operator']==2) { echo "selected";}?>>is not equal to</option>
                               <option value="3"  <?php if(@$user_invoice_search['inumber_operator']==3) { echo "selected";}?>>greater than</option>
                               <option value="4"  <?php if(@$user_invoice_search['inumber_operator']==4) { echo "selected";}?>>less than</option>
                               <option value="5"  <?php if(@$user_invoice_search['inumber_operator']==5) { echo "selected";}?>>greather or equal than</option>
                               <option value="6"  <?php if(@$user_invoice_search['inumber_operator']==6) { echo "selected";}?>>less or equal than</option>
                               </select>
                         </span>
                         </div>

                        <div class="float-left" style="width:300px;">
                            <span>
                                <label> Invoice Date:</label>
                                <input size="20" class="text field" name="invoice_date" id="from_date"/> 
                            </span>
                        </div>
                        <div class="float-left" style="width:400px;">
                         <span>
                               <label>Invoice Total:</label>
                               <input size="20" class="text field" name="creditlimit" value="<?=@$user_invoice_search['creditlimit']?>" > &nbsp;
                               <select name="creditlimit_operator" class="field select" style="width:132px;" >
                               <option value="1" <?php if(@$user_invoice_search['creditlimit_operator']==1) { echo "selected";}?> >is equal to</option>
                               <option value="2"  <?php if(@$user_invoice_search['creditlimit_operator']==2) { echo "selected";}?>>is not equal to</option>
                               <option value="3"  <?php if(@$user_invoice_search['creditlimit_operator']==3) { echo "selected";}?>>greater than</option>
                               <option value="4"  <?php if(@$user_invoice_search['creditlimit_operator']==4) { echo "selected";}?>>less than</option>
                               <option value="5"  <?php if(@$user_invoice_search['creditlimit_operator']==5) { echo "selected";}?>>greather or equal than</option>
                               <option value="6"  <?php if(@$user_invoice_search['creditlimit_operator']==6) { echo "selected";}?>>less or equal than</option>
                               </select>
                         </span>
                         </div>
                    </li>
                </fieldset>
            </ul>
            <br/>
            <input type="button" id="id_reset" class="ui-state-default float-right ui-corner-all ui-button" name="reset" value="Clear Search Filter">&nbsp; 
            <input type="button" class="ui-state-default float-right ui-corner-all ui-button" name="action" value="Search" id="invoice_search" style="margin-right:22px;" />
            <br><br>
        </form>
    </div>
</div>        





<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
            <div class="portlet-header ui-widget-header">Account Taxes<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content">
            <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">
            <table id="flex1" align="left" style="display:none;"></table>
            </form>
            </div>
</div>



<?php 
	//echo $form;
?>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>