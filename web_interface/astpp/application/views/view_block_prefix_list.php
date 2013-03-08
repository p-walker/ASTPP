<script type="text/javascript">
function selected_routes(route_id){
    if($('#chk'+route_id).is(':checked') == true){ 
      text = "";
      if(document.getElementById("add_patterns").value !="")
	  var text =  document.getElementById("add_patterns").value;      
      text += route_id+",";
	$.ajax({
	    type     : "POST",
	    cache    : false,
	    async    : true, 
	    data:"prefixes="+text,  
	    url      : "/accounts/set_selected_prefixes",
	    success: function(data){
		$("#add_patterns").val(text);      
	    }
	});
      
    } else{
      var text = document.getElementById("add_patterns").value;      
      newtext = text.replace(route_id+",",'');
	$.ajax({
	    type     : "POST",
	    cache    : false,
	    async    : true, 
	    data:"prefixes="+newtext,  
	    url      : "/accounts/set_selected_prefixes",
	    success: function(data){
		$("#add_patterns").val(newtext);
 	    }
 	});
    }
}
$(document).ready(function() {

    var showOrHide=false;
    $("#search_bar").toggle(showOrHide);
	
$("#flex1").flexigrid({
    url: "<?php echo base_url();?>accounts/routes_grid/<?=$account_num?>",
    method: 'GET',
    dataType: 'json',
	colModel : [
 		{display: 'ALL', name: 'ALL', width: 50,align: 'center'},
		{display: 'Code', name: 'country', width: 200, sortable: false, align: 'center'},
		{display: 'Destination', name: 'province', width: 220, sortable: false, align: 'left'},
		],
	buttons : [{name: 'Remove Search Filter', bclass: 'reload', onpress : clear_filter}],
	nowrap: false,
			
	showToggleBtn: false,
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: true,
	useRp: true,
	rp: 10,
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
        	loadingImage : '<?php echo base_url();?>/assets/images/loading.gif',
        	closeImage   : '<?php echo base_url();?>/assets/images/closelabel.png'
      	});
    },
    onError: function(){
        alert("Request failed");
    },
});

$("#rates_routes_search").click(function(){
	$.ajax({type:'POST', url: '<?=base_url()?>accounts/routes_search', data:$('#search_form12').serialize(), success: function(response) {
	      $('#flex1').flexReload();
	    }});
	});
	
	$("#id_reset").click(function(){
		$.ajax({url:'<?=base_url()?>accounts/clearsearchfilter_routes/', success: function(){
		$('#flex1').flexReload(); }
		});
	});
	
	$("#show_search").click(function(){
	  $("#search_bar").toggle();
	});

	$("#add_patterns_btn").click(function(){
	  if(document.getElementById("add_patterns").value !=""){
	      $.ajax({
		type     : "POST",
		cache    : false,
		async    : true, 
		data:$('#addlist_form').serialize(),  
		url      : "/accounts/insert_block_prefix/<?=$account_num?>",
		success: function(data){
		    //window.close();
		  document.getElementById("add_patterns").value = "";
// 		  $("#add_patterns").val("");      
		  $('#flex1').flexReload();
		  $('#flex8').flexReload();
		}
	      });
	  } else{
	      alert("Please select some code first");
	  }
	  
	});
});

function clear_filter()
{
	window.location = '<?php echo base_url();?>rates/clearsearchfilter_routes/';
}
function reload_button()
{
    $('#flex1').flexReload();
}

</script>			
<form action="" id="addlist_form" name="addlist_form" method="POST" enctype="multipart/form-data" style="display:block">
<input type="hidden" id="add_patterns" name="add_patterns" readonly>&nbsp;   
<input type="button" id="add_patterns_btn" class="ui-state-default float-right ui-corner-all ui-button" name="add_patterns_btn" value="Add To List">
</form>
<br/>
	<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="searchbar">                        
            <div class="portlet-header ui-widget-header"><span id="show_search" style="cursor:pointer">Search</span><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content"  id="search_bar">           
	         <form action="<?=base_url()?>rates/routes_search" id="search_form12" name="form12" method="POST" enctype="multipart/form-data" style="display:block">
             <input type="hidden" name="ajax_search" value="1">
         <input type="hidden" name="advance_search" value="1">
         <ul style="list-style:none;">
          <fieldset >
            <legend><span style="font-size:14px; font-weight:bold; color:#000;">Search Origination Rates</span></legend>
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
        <div class="portlet-header ui-widget-header">Rates List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">
        <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">        
        <table id="flex1" align="left" style="display:none;"></table>
        </form>
        </div>
</div>

