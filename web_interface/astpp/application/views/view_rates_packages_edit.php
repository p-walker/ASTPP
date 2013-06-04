<? extend('master.php') ?>
	<? startblock('extra_head') ?>	   
	<script type="text/javascript" src="<?=base_url()?>js/ui/ui.tabs.js"></script>
	  <? startblock('page-title') ?>
		<?=$page_title?><br/>
	  <? endblock() ?>
	<? startblock('content') ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabs').tabs();

      $("#add_to_list").focus(function(){
	$("#error").hide();
      })
      $("#add_to_list_btn").click(function(){ 
	  if(document.getElementById("add_to_list").value !=""){
	      $.ajax({
		type     : "POST",
		cache    : false,
		async    : true, 
		data:$('#addlist').serialize(),  
		url      : "/rates/insert_package_pattern/<?=$package['id']?>",
		success: function(data){
		  if(data == 0){ 
		      document.getElementById("add_to_list").value = "";
		      document.getElementById('error').innerHTML ="Duplicate pattern Found.";
		      $("#error").show();
		  } else {
		    document.getElementById("add_to_list").value = "";
		    $('#flex8').flexReload();
		  }
		}
	      });
	  } else{
	      document.getElementById('error').innerHTML ="Please Enter Some pattern.";
	      $("#error").show();
	  }
	  
	});

    $("#flex8").flexigrid({
	url: "<?php echo base_url();?>rates/packages_pattern_json/<?=$package['id']?>/",
	method: 'GET',
	dataType: 'json',
	colModel : [	{display: '<input type="checkbox" name="chkAll" class="checkall"/>', name : 'chkDelete', width : 45, sortable : false, align: 'left'},				{display: 'Package Pattern', name: 'PackagePattern', width:200,  sortable: false, align: 'center'},
			{display: 'Action',name: 'Action',width:70, align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'',},}	
		   ],
	buttons :  [{name: 'Add Patterns', bclass: 'add', onpress : add_button},
		    {separator: true},
		    {name: 'Delete Selected', bclass: 'delete', onpress : removeFromList},],
	nowrap: false,
	showToggleBtn: false,
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: false,
	title: 'Package Pattern List',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	height: "auto",
	width: "auto",	
	pagetext: 'Page',
	outof: 'of',
	nomsg: 'No items',
	procmsg: 'Processing, please wait ...',
	pagestat: 'Displaying {from} to {to} of {total} items',
	onSuccess: function(data){
	    $('a[rel*=facebox]').facebox({
			    loadingImage : '<?=base_url();?>assets/images/loading.gif',
			    closeImage   : '<?=base_url();?>assets/images/closelabel.png'
	    });
	},
	onError: function(){
	    alert("Request failed");
	}
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
    var result = "";                        
    $(".chkRefNos").each( function () {
      if(this.checked == true) {     
        result += ",'"+$(this).val()+"'";
      } 
    });     
    result = result.substr(1);
    if(result){
      confirm_string = 'Are you sure want to delete selected patterns?';
      var answer = confirm(confirm_string);
      if(answer){
	  $.ajax({
	    type: "POST",
	    cache    : false,
	    async    : true,  
	    url: "/rates/remove_selected_package_details/",
	    data: "deletable_id="+result,
	    success: function(data){
		if(data == 1)
		{
		    $('#flex8').flexReload();
		} else{
		  alert("Problem In delete records.");
		}
	      }
	  });
      }
    } else{
	alert("Please select atleast one pattern to delete.");
    }
//     alert(result);  // I will get comma separated selected row ids
  }


    function add_button()
    {
	jQuery.facebox({ ajax: '<?php echo base_url(); ?>rates/add_package_patterns/<?=$package['id']?>/'});
    }

</script>
<div id="tabs">
	<ul>
		<li><a href="#package_details">Package Details</a></li>
		<li><a href="#package_patterns">Package Patterns</a></li>
	</ul>	
    <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">                        
            <div class="portlet-header ui-widget-header">Edit Package<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
            <div class="portlet-content" id="package_details">
            <form method="post" action="<?=base_url()?><?=isset($package)?"rates/packages/edit":"rates/packages/add"?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo @$package['id'];?>"  />
            <ul style="width:600px">
            <fieldset  style="width:585px;">
            <legend><span style="font-size:14px; font-weight:bold; color:#000;">Packages Information</span></legend>
            <li>
            <label class="desc">Packages Name:</label><input class="text field medium"  value="<?php echo @$package['name'];?>" type="text" name="name"  size="20" />
            </li>
            <li>
            <label class="desc">Pricelist:</label>
            <select class="select field medium" name="pricelist" >
            <?=$pricelists?>
            </select>
            </li>
<!--            <li>
            <label class="desc">Pattern:</label><input class="text field medium" type="text" value="<?php //echo @$package['pattern'];?>" name="pattern"  size="20" />
            </li>-->
            <li>
            <label class="desc">Included in Seconds:</label>
            <input class="text field medium" type="text" name="includedseconds" value="<?php echo @$package['includedseconds'];?>"  size="8" />
            </li>
            </fieldset>
			</ul>
            <div style="width:100%;float:left;height:50px;margin-top:20px;">
            <input class="ui-state-default float-right ui-corner-all ui-button" type="submit" name="action" value="<?=isset($package)?"Save...":"Insert..."?>" />
            </div>
            </form>            
            </div>

	    <div id="package_patterns">
			  <div class="hastable" style="margin-bottom:10px;">   
			    <form action="" id="addlist" name="addlist" method="POST" enctype="multipart/form-data" style="display:block">
			      <span id="error" style="color:red;">&nbsp;</span><br/>
			      <input type="text" id="add_to_list" name="add_to_list">&nbsp;
			      <input type="button" id="add_to_list_btn" class="ui-state-default  ui-corner-all ui-button" name="add_to_list_btn" value="Add To List">
			    </form>
			  </div>

		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
		    <div class="portlet-header ui-widget-header">Package Pattern List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
		      <div class="portlet-content">          
			  <div>   
			      <table id="flex8" align="left" style="display:none;"></table>                  
			  </div>
		      </div>
		    </div> 
	    </div>

</div>
</div>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>