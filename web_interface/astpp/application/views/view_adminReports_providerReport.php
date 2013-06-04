<? extend('master.php') ?>

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
    url: "<?php echo base_url();?>adminReports/providerReport/grid/",
    method: 'GET',
    dataType: 'json',
	colModel : [
		{display: 'Provider', name: 'Number', width:120,  sortable: false, align: 'center'},
		{display: 'Code', name: 'code',width:100, sortable: false, align: 'center'},	
		{display: '<acronym title="International Direct Dialling Code">IDD Code</acronym>', name: 'province',width:150, sortable: false, align: 'center'},
		{display: 'Attempted Calls', name: 'province',width:120, sortable: false, align: 'center'},
		{display: 'Completed Calls', name: 'CompletedCalls',width:100, sortable: false, align: 'center'},			
		{display: '<acronym title="Answer Seizure Rate.">ASR</acronym>', name: 'province',width:80, sortable: false, align: 'center'},		
		{display: '<acronym title="Average Call Duration">ACD</acronym>',width:80, name: 'city',  sortable: false, align: 'center'},     		
		{display: '<acronym title="Maximum Call Duration">MCD</acronym>',width:80, name: 'city',  sortable: false, align: 'center'},
		{display: 'Actual',width:80, name: 'provider',  sortable: false, align: 'center'},
		{display: 'Billable', width:100,name: 'status',  sortable: false, align: 'center'},
		{display: 'Cost', width:80,name: 'province',  sortable: false, align: 'center'},
	],
	buttons : [
		{name: 'Remove Search Filter', bclass: 'reload', onpress : clear_filter},
	],
	nowrap: false,
	showToggleBtn: false,
	sortname: "Provider",
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
        
function format() {
	
    var gridContainer = this.Grid.closest('.flexigrid');
    //alert(gridContainer);
    var headers = gridContainer.find('div.hDiv table tr:first th:not(:hidden)');
    var drags = gridContainer.find('div.cDrag div');
    var offset = 0;
    var firstDataRow = this.Grid.find('tr:first td:not(:hidden)');
    var columnWidths = new Array( firstDataRow.length );
    this.Grid.find( 'tr' ).each( function() {
    	
        $(this).find('td:not(:hidden)').each( function(i) {
            var colWidth = $(this).outerWidth();
            if (!columnWidths[i] || columnWidths[i] < colWidth) {
                columnWidths[i] = colWidth;
            }
        });
    });
    for (var i = 0; i < columnWidths.length; ++i) {
        var bodyWidth = columnWidths[i];
		alert(bodyWidth);
        var header = headers.eq(i);
        var headerWidth = header.outerWidth();

        var realWidth = bodyWidth > headerWidth ? bodyWidth : headerWidth;

        firstDataRow.eq(i).css('width',realWidth);
        header.css('width',realWidth);            
        drags.eq(i).css('left',  offset + realWidth );
        offset += realWidth;
    }
}

$("#id_filter").click(function(){
	var start_date = ($("#start_date").val()=='' ? 'NULL' : $("#start_date").val());
	var end_date = ($("#end_date").val()=='' ? 'NULL' : $("#end_date").val());
	var Provider = $("#Reseller").val();
	var destination = $("#destination").val();
	var pattern = $("#pattern").val();
	
	var start_hour = $("#start_hour").val();
	var start_minute = $("#start_minute").val();
	var start_second = $("#start_second").val();
	var end_hour = $("#end_hour").val();
	var end_minute = $("#end_minute").val();
	var end_second = $("#start_hour").val();
	
	//var flex_url = "<?php echo base_url();?>adminReports/resellerReport/grid/?"+encodeURIComponent("filter_ok=1&account="+account+"&company="+company+"&fname="+fname+"&lname="+lname);
	flex_url = "<?php echo base_url();?>adminReports/providerReport/grid/"+start_date+"/"+end_date+"/"+Provider+"/"+destination+"/"+encodeURIComponent(pattern)+"/"+start_hour+"/"+start_minute+"/"+start_second+"/"+end_hour+"/"+end_minute+"/"+end_second;
	$('#flex1').flexOptions({url: flex_url}).flexReload();
});
$("#id_reset").click(function(){
	$("#start_date").val('');
	$("#end_date").val('');
});

$("#search_providerreport").click(function(){	

	$.ajax({type:'POST', url: '<?=base_url()?>adminReports/provider_search', data:$('#search_form3').serialize(), success: function(response) {
    $('#flex1').flexReload();
}});
	});
	
	$("#id_reset").click(function(){
		$.ajax({url:'<?=base_url()?>adminReports/clearsearchfilter_provider/', success:function(){
		$('#flex1').flexReload(); }
		});
	});
	
	$("#show_search").click(function(){
	$("#search_bar").toggle();
	});

});

function add_button()
{
    window.location = '<?php echo base_url();?>callingcards/add/';
}

function clear_filter()
{
	window.location = '<?php echo base_url();?>adminReports/clearsearchfilter_provider/';
}

function delete_button()
{
	confirm_string = '{% trans " you are hiding & stopping a campaign" %}';
    if( confirm("are you sure to delete?") == true)
	    $('#ListForm').submit();
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
    
        <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
            <div class="portlet-header ui-widget-header"><span id="show_search" style="cursor:pointer">Search</span><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content" id="search_bar">
             <script>
			  $(document).ready(function() {
				$("#provider_from_date").datetimepicker({ dateFormat: 'yy-mm-dd' });		
				$("#provider_to_date").datetimepicker({ dateFormat: 'yy-mm-dd' });			
			  });
			  </script> 
				 <form action="<?=base_url()?>adminReports/provider_search" id="search_form3" name="form3" method="POST" enctype="multipart/form-data" style="display:block">
                 <input type="hidden" name="ajax_search" value="1">
				 <input type="hidden" name="advance_search" value="1">
				 <ul style="list-style:none;">
				  <fieldset  style="">
					<legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Provider Report</span></legend>
                    <li>
                    	 <div class="float-left" style="width:30%">
                			<span>
                             <label >Provider:</label>
							<input size="20" class="text field" name="reseller" id="reseller">
						<a onclick="window.open('<?=base_url()?>adminReports/provider_list/' , 'ProviderList','scrollbars=1,width=650,height=330,top=20,left=100,scrollbars=1');" href="#"><img src="<?=base_url()?>images/icon_arrow_orange.gif" border="0"></a>
                            </span>
                         </div> 
                         
                          <div class="float-left" style="width:30%">
                			<span>
                            <label>Code:</label>
                            <select class="select field" name="Destination" id="Destination"  style="width:307px;">
                            <option value="ALL">ALL</option>
                            <?php foreach($pattern as $key => $value)
                                {
                                    if($value!="")
                                    {
                                
                                    ?>
                                    <option value="<?php echo $value?>" <?php if(@$Destination==$value) { echo "selected";}?> ><?php echo $value?></option>
                                    <?
                                    }
                                }?>
                            </select>
                            </span>
                         </div> 
                         
                          <!--<div class="float-left" style="width:30%">
                			<span>
                              <label>IDD Code:</label>
                              <select class="select field" name="Pattern" value="IDD Code" id="Pattern"  style="width:307px;">
                              <option value="ALL">ALL</option>
                              <?php foreach($pattern as $key => $value)
                                    {
                                        if($value!="")
                                        {
                                        ?>
                                        <option value="<?php echo $value?>" <?php if(@$Pattern==$value) { echo "selected";}?> ><?php echo $value?></option>
                                        <?
                                        }
                                    }
                             ?>
                              </select>
                            </span>
                         </div>   -->
                  </li>
					 <li>
                     	<div class="float-left" style="width:30%">
                			<span>
                            <label >Start Date & Time  :</label>
							<input size="20" class="text field" name="start_date" id="provider_from_date">&nbsp;<img src="<?=base_url()?>images/calendar.png" border="0">  	
                            </span>
                        </div> 
                        	<div class="float-left" style="width:30%">
                			<span>
                            	<label >End Date & Time:</label>
								<input size="20" class="text field" name="end_date" id="provider_to_date"> &nbsp;<img src="<?=base_url()?>images/calendar.png" border="0">       
                            </span>
                            </div>                           	
                     </li> 
					
					</fieldset>
				  </ul>
				   <br />
                  <input type="button" id="id_reset" class="ui-state-default float-right ui-corner-all ui-button" name="reset" value="Clear Search Filter">&nbsp;      
				<input type="button" class="ui-state-default float-right ui-corner-all ui-button" name="action" value="Search" id="search_providerreport" style="margin-right:22px;" />
				<br><br>
				 </form>
              <!--<fieldset >
                      <div>
                      <ul id="search-filters2" style="width:1260px">
                      <li>
                      <label class="desc">Start date:</label><input class="text field medium" type="text" name="start_date" value="<?=@$start_date?>" size="5" id="start_date">
                      </li>
                      <li>
                      <label class="desc">Start time:</label>
                      <input class="text field small" type="text" name="start_hour" id="start_hour" value="<?=@$start_hour?>" size="5">
                      <input class="text field small" type="text" name="start_minute" id="start_minute" value="<?=@$start_minute?>" size="5">
                      <input class="text field small" type="text" name="start_second" id="start_second" value="<?=@$start_second?>" size="5">
                      </li>
                      <li>
                      <label class="desc">End time:</label>
                      <input class="text field small" type="text" name="end_hour" id="end_hour" value="<?=@$end_hour?>" size="5">
                      <input class="text field small" type="text" name="end_minute" id="end_minute" value="<?=@$end_minute?>" size="5">
                      <input class="text field small" type="text" name="end_second" id="end_second" value="<?=@$end_second?>" size="5">
                      </li>
                      <li>
                      <label class="desc">End date:</label><input class="text field medium" type="text" name="end_date" value="<?=@$end_date?>" size="5" id="end_date">
                      </li>
                      <li>
                      <label class="desc">Provider:</label>
                      <select class="select field medium" name="Reseller" value="ALL" id="Reseller">
                      <option value="ALL">ALL</option>
                      <?php foreach($reseller as $key => $value) {				
						?>
                      <option value="<?php echo $value?>" <?php if($Reseller==$value) { echo "selected";}?> ><?php echo $value?></option>
                      <? } ?>
                      </select> 
                      </li>
                      <li>
                      <label class="desc">Destination:</label>
                      <select class="select field medium" name="destination" value="Destination" id="destination">
						<option value="ALL">ALL</option>
                        <?php foreach($destination as $key => $value)
							{
								if($value!="")
								{
							
								?>
                            	<option value="<?php echo $value?>" <?php if($Destination==$value) { echo "selected";}?> ><?php echo $value?></option>
                            	<?
								}
							}?>
					  </select>
                      </li>
                      <li>
                      <label class="desc">IDD Code:</label>
                      <select class="select field medium" name="pattern" value="IDD Code" id="pattern">
                      <option value="ALL">ALL</option>
                      <?php foreach($pattern as $key => $value)
					  		{
						  		if($value!="")
								{
								?>
                            	<option value="<?php echo $value?>" <?php if($Pattern==$value) { echo "selected";}?> ><?php echo $value?></option>
                            	<?
								}
							}
					 ?>
                      <option value=""></option>
                      </select>
                      </li>
                      <li style="width:160px; margin-top:17px">                      
                      <input type="button" id="id_filter" value="Search" class="ui-state-default ui-corner-all ui-button" />&nbsp;
                      </li>
                      </ul>
                      <br/>
                  
                      </div>
              </fieldset>-->           
            </div>
        </div>        


<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
    <div class="portlet-header ui-widget-header">Provider Report<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
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