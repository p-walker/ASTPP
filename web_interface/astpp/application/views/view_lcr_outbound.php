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
    url: "<?php echo base_url();?>lcr/outbound_grid/",
    method: 'GET',
    dataType: 'json',
	colModel : [
<!--        {display: '<input type="checkbox" onclick="toggleChecked(this.checked)">', name: '', width: 20, align: 'center'},\
-->
	{display: '<input type="checkbox" name="chkAll" class="checkall"/>', name : 'chkDelete', width : 45, sortable : false, align: 'left'},
// 	{display: 'ID', name: 'Number', width: 50, sortable: false, align: 'center'},
        {display: 'Code', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Prepend', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Destination', name: 'province', width: 120, sortable: false, align: 'left'},
        {display: 'Trunk', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Increment', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Connect<br/>Charge', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Included<br/>Seconds', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Cost Per<br/>Add. Minute', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Precedence', name: 'country', width: 80, sortable: false, align: 'center'},
        {display: 'Resellers', name: 'country', width: 100, sortable: false, align: 'center'},
        {display: 'Action', name: '', width : 80, align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, },

		],
    buttons : [
		{name: 'Add', bclass: 'add', onpress : add_button},
		{separator: true},
		{name: 'Import', bclass: 'import', onpress : import_button},
		{separator: true},
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		{separator: true},
		{name: 'Delete Selected', bclass: 'delete', onpress : removeFromList},
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
	height:"auto",	
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
    },
});

$("#lcr_outbound_search").click(function(){ 
	$.ajax({type:'POST', url: '<?=base_url()?>lcr/outbound_search', data:$('#search_form10').serialize(), success: function(response) {
        $('#flex1').flexReload();
		}});
	});
	
	$("#id_reset").click(function(){
		$.ajax({url:'<?=base_url()?>lcr/clearsearchfilter_outbound/', success:function(){
		$('#flex1').flexReload(); }
		});
	});
	
	
    $("#show_search").click(function(){
	$("#search_bar").toggle();
    });
    $('.checkall').click(function () {
        $('.chkRefNos').attr('checked', this.checked); //if you want to select/deselect checkboxes use this
    });

});

function cickchkbox(chkid){
  var chk_flg = 0;
    $(".chkRefNos").each( function () {
      if(this.checked == false) {     
        $('.checkall').attr('checked', false);
	chk_flg++;
      } 
    });
    if(chk_flg == 0){
      $('.checkall').attr('checked', true);
    }
}

  function removeFromList(){
    confirm_string = 'Are you sure want to delete selected rates?';
    var answer = confirm(confirm_string);

    var result = "";                        
    $(".chkRefNos").each( function () {
      if(this.checked == true) {     
        result += ",'"+$(this).val()+"'";
      } 
    });     
    result = result.substr(1);
    if(answer){
      if(result){
	  $.ajax({
	    type: "POST",
	    cache    : false,
	    async    : true,  
	    url: "/lcr/delete_selected_outbound_rates/",
	    data: "deletable_id="+result,
	    success: function(data){
		if(data == 1)
		{
		    $('#flex1').flexReload();
		} else{
		  alert("Problem In delete records.");
		}
	      }
	  });
      } else{
	  alert("Please select atleast one rate to delete.");
      }
    }
//     alert(result);  // I will get comma separated selected row ids
  }


function add_button()
{
    jQuery.facebox({ ajax: '<?php echo base_url();?>lcr/outbound/add/'});
}
function clear_filter()
{
	window.location = '<?php echo base_url();?>lcr/clearsearchfilter_outbound/';
}
function import_button()
{
    jQuery.facebox({ ajax: '<?php echo base_url();?>lcr/import_outbound'});
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
	
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
<br/>
	<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="searchbar">                        
            <div class="portlet-header ui-widget-header"><span id="show_search" style="cursor:pointer">Search</span><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content" id="search_bar">
           
	         <form action="<?=base_url()?>lcr/outbound_search" id="search_form10" name="form10" method="POST" enctype="multipart/form-data" style="display:block">
               <input type="hidden" name="ajax_search" value="1">
         <input type="hidden" name="advance_search" value="1">
         <ul style="list-style:none;">
          <fieldset>
            <legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Termination Rates</span></legend>
            	<li>
                 <div class="float-left" style="width:30%">
                <span>
                  <label>Code:</label>
                  <input size="20" class="text field" name="pattern"> &nbsp;
                  <select name="pattern_operator"  class="field select">
                  <option value="1">contains</option>
                  <option value="2">doesn't contain</option>
                  <option value="3">is equal to</option>
                  <option value="4">is not equal to</option>
                  </select>
                </span>
                </div>
                
                <div class="float-left" style="width:30%">
                <span>
                   <label >Prepend:</label>
                   <input size="20" class="text field" name="prepend"> &nbsp;
                   <select name="prepend_operator"  class="select field">
                   <option value="1">contains</option>
                   <option value="2">doesn't contain</option>
                   <option value="3">is equal to</option>
                   <option value="4">is not equal to</option>
                   </select>
                </span>
                </div>
                
                <div class="float-left" style="width:30%">
                <span>
                 <label>Destination:</label>
            	 <input size="20" class="text field" name="comment"> &nbsp;
                 <select name="comment_operator"  class="select field">
                 <option value="1">contains</option>
                 <option value="2">doesn't contain</option>
                 <option value="3">is equal to</option>
                 <option value="4">is not equal to</option>
                 </select>
                </span>
                </div>
                
                </li>
             <li>   
          		 <div class="float-left" style="width:30%">
                <span>
                  <label >Trunk</label>
                  <select class="select field" name="trunk" style="width:307px;" >
                  <?=$trunks?>
                  </select>
                </span>
                </div>
                
                <div class="float-left" style="width:30%">
                <span>
                  <label>Increment :</label>
               <input size="20" class="text field" name="increment"> &nbsp;
               <select name="increment_operator"  class="select field" style="width:132px;">
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
                  <label >Connect Charge :</label>
                  <input size="20" class="text field" name="connect_charge"> &nbsp;
                  <select name="connect_charge_operator"  class="select field" style="width:132px;">
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
                  <label >Included Seconds:</label>
                  <input size="20" class="text field" name="included_seconds"> &nbsp;
                  <select name="included_seconds_operator"  class="select field" style="width:132px;">
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
                    <select name="cost_per_add_minutes_operator" class="select field" style="width:132px;">
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
                  <label >Reseller:</label>
               <input size="20" class="text field" name="reseller" id="reseller">
               <a onclick="window.open('<?=base_url()?>accounts/search_outbound_reseller_list/' , 'ResellerList','scrollbars=1,width=650,height=330,top=20,left=100,scrollbars=1');" href="#"><img src="<?=base_url()?>images/icon_arrow_orange.gif" border="0"></a>	
                </span>
                </div>
                
             </li>          
              
         </fieldset> 
            <br />
             <input type="reset" id="id_reset" class="ui-state-default float-right ui-corner-all ui-button" name="reset" value="Clear Search Filter">&nbsp;
            <input type="button" class="ui-state-default float-right ui-corner-all ui-button" name="action" value="Search" id="lcr_outbound_search" style="margin-right:22px;" />
            <br><br>  
          </ul>
         </form>             
          </div>
        </div>
        
		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
        <div class="portlet-header ui-widget-header">Termination Rates List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
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