<? extend('user_master.php') ?>
<? startblock('extra_head') ?>

<script type="text/javascript">
$(document).ready(function() {
	
	var showOrHide=false;
	$("#search_bar").toggle(showOrHide);
	
$("#flex1").flexigrid({
    url: "<?php echo base_url();?>user/rates_grid/",
    method: 'GET',
    dataType: 'json',
	colModel : [	    
	    {display: 'Code', name: 'country', width: 100, sortable: false, align: 'center'},
	    {display: 'Destination', name: 'province', width: 150, sortable: false, align: 'left'},    
	    {display: 'Included Seconds', name: 'province', width: 100, sortable: false, align: 'left'},
	    {display: 'Increments', name: 'province', width: 80, sortable: false, align: 'left'},
	    {display: 'Connect Charge', name: 'province', width: 150, sortable: false, align: 'left'},
	    {display: 'Cost Per Add. Minute', name: 'province', width: 150, sortable: false, align: 'left'}	    
	],
	buttons : [
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		{separator: true},
		{name: 'Remove Search Filter', bclass: 'reload', onpress : clear_filter},
		],
	nowrap: false,
			
	showToggleBtn: false,
	sortname: "Code",
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
    nomsg: 'No Rates Found',
    procmsg: 'Processing, please wait ...',
    pagestat: 'Displaying {from} to {to} of {total} rates',    
    onSuccess: function(data){
        $('a[rel*=facebox]').facebox({
        	loadingImage : '<?php echo base_url();?>/images/loading.gif',
        	closeImage   : '<?php echo base_url();?>/images/closelabel.png'
      	});
    },
    onError: function(){
        alert("Request failed");
    },
});

$("#rates_routes_search").click(function(){
	$.ajax({type:'POST', url: '<?=base_url()?>user/rates_search', data:$('#search_form12').serialize(), success: function(response) {
    $('#flex1').flexReload();
		}});
	});
	
	$("#id_reset").click(function(){
		$.ajax({url:'<?=base_url()?>user/clearsearchfilter_rates/', success: function(){
		$('#flex1').flexReload(); }
		});
	});
	
	$("#show_search").click(function(){
	$("#search_bar").toggle();
	});

});

function clear_filter()
{
	window.location = '<?php echo base_url();?>user/clearsearchfilter_rates/';
}

function reload_button()
{
    $('#flex1').flexReload();
}

</script>
    <? endblock() ?>
    <? startblock('page-title') ?>
        <?=ucfirst($page_title)?><br/>
    <? endblock() ?>
    <? startblock('content') ?>
      <br/>
	<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="searchbar">                        
            <div class="portlet-header ui-widget-header"><span id="show_search" style="cursor:pointer">Search</span><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content"  id="search_bar">           
	         <form action="<?=base_url()?>rates/routes_search" id="search_form12" name="form12" method="POST" enctype="multipart/form-data" style="display:block">
             <input type="hidden" name="ajax_search" value="1">
         <input type="hidden" name="advance_search" value="1">
         <ul style="list-style:none;">
          <fieldset >
            <legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Rates</span></legend>
            <li>
            	 <div class="float-left" style="width:30%">
                 <span>
                   <label>Code:</label>
                   <input size="20" class="text field" name="pattern"> &nbsp;
                   <select name="pattern_operator" class="field select ">
                   <option value="1">contains</option>
                   <option value="2">doesn't contain</option>
                   <option value="3">is equal to</option>
                   <option value="4">is not equal to</option>
                   </select>
                 </span>
                 </div>
                  <div class="float-left" style="width:30%">
                 <span>
                   <label >Destination:</label>
                   <input size="20" class="text field" name="comment"> &nbsp;
                   <select name="comment_operator" class="field select">
                   <option value="1">contains</option>
                   <option value="2">doesn't contain</option>
                   <option value="3">is equal to</option>
                   <option value="4">is not equal to</option>
                   </select>
                 </span>
                 </div>
                 
                 <div class="float-left" style="width:30%">
                 <span>
                    <label >Included Seconds:</label>
                    <input size="20" class="text field" name="included_seconds"> &nbsp;
                    <select name="included_seconds_operator"  class="field select" style="width:132px;" >
                    <option value="1">is equal to</option>
                    <option value="2">is not equal to</option>
                    <option value="3">greater than</option>
                    <option value="4">less than</option>
                    <option value="5">greather or equal than</option>
                    <option value="6">less or equal than</option>
                    </select>
                 </span>
                 </div>
            </li>	
            <li>
	       <div class="float-left" style="width:30%">
                 <span>
                   <label>Increment :</label>
                   <input size="20" class="text field" name="increment"> &nbsp;
                   <select name="increment_operator" class="field select" style="width:132px;">
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
                  <label>Connect Charge :</label>
                  <input size="20" class="text field" name="connect_charge"> &nbsp;
                  <select name="connect_charge_operator" class="field select" style="width:132px;">
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
                    <label>Cost per add. Minutes:</label>
                    <input size="20" class="text field" name="cost_per_add_minutes"> &nbsp;
                    <select name="cost_per_add_minutes_operator"  class="field select" style="width:132px;" >
                    <option value="1">is equal to</option>
                    <option value="2">is not equal to</option>
                    <option value="3">greater than</option>
                    <option value="4">less than</option>
                    <option value="5">greather or equal than</option>
                    <option value="6">less or equal than</option>
                    </select>
                 </span>
                 </div>
            </li> 
         </fieldset> 
            <br />
             <input type="button" id="id_reset" class="ui-state-default float-right ui-corner-all ui-button" name="reset" value="Clear Search Filter">&nbsp;   
            <input type="button" class="ui-state-default float-right ui-corner-all ui-button" name="action" value="Search" id="rates_routes_search" style="margin-right:22px;" />
            <br><br>  
          </ul>
         </form>             
          </div>
        </div>
        
	<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
        <div class="portlet-header ui-widget-header">Rate List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">
        <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">        
        <table id="flex1" align="left" style="display:none;"></table>
        </form>
        </div>
    </div>
    <? endblock() ?>
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
<? end_extend() ?>