<? extend('master.php') ?>
	<? startblock('extra_head') ?>	   
	<script type="text/javascript" src="<?=base_url()?>js/ui/ui.tabs.js"></script>
	
	<script type="text/javascript">
$(document).ready(function() {
	
$("#flex1").flexigrid({
    url: "<?php echo base_url();?>accounts/account_detail_json/<?=$account_number?>/",
    method: 'GET',
    dataType: 'json',
	colModel : [
		{display: 'UniqueID', name: 'UniqueID', width:80,  sortable: false, align: 'center'},
		{display: 'Date & Time', name: 'DateTime',width:80, sortable: false, align: 'center'},
		{display: 'Caller*ID', name: 'CallerID',width:90, sortable: false, align: 'center'},
		{display: 'Called Number', name: 'CalledNumber',width:90, sortable: false, align: 'center'},
		{display: 'Disposition', name: 'Disposition',width:90, sortable: false, align: 'center'},
		{display: 'Billable Seconds', name: 'BillableSeconds',width:90, sortable: false, align: 'center'},
		{display: 'Charge', name: 'Charge', width:90, sortable: false, align: 'center'},
		{display: 'Credit', name: 'Credit', width:90,  sortable: false, align: 'center'},
		{display: 'Notes', width:120,name: 'Notes',  sortable: false, align: 'center'},
		{display: 'Cost',width:60, name: 'Cost',  sortable: false, align: 'center'},
		{display: 'Profit', width:100,name: 'Profit',  sortable: false, align: 'center'},        
		],
	buttons : [		
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		],
	nowrap: false,
	showToggleBtn: false,
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: true,
	title: '',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	height: 200,
	width: "auto",	
    pagetext: 'Page',
    outof: 'of',
    nomsg: 'No items',
    procmsg: 'Processing, please wait ...',
    pagestat: 'Displaying {from} to {to} of {total} items',
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
        
function format() {
	
    var gridContainer = this.Grid.closest('.flexigrid');
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
});


</script>	
<script type="text/javascript">
      $(document).ready(function() {
	      
      $("#flex5").flexigrid({
	  url: "<?php echo base_url();?>accounts/ip_json/<?=$account_number?>/",
	  method: 'GET',
	  dataType: 'json',
	      colModel : [			
		      {display: 'IP Address', name: 'IPAddress', width:120,  sortable: false, align: 'center'},
		      {display: 'Prefix', name: 'Prefix',width:120, sortable: false, align: 'center'},
		      {display: 'Context', name: 'ipcontext',width:120, sortable: false, align: 'center'},
		      {display: 'Action',width:120, name: '', align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, }, 	
		      ],
	  buttons : [
		      {name: 'Refresh', bclass: 'reload', onpress : reload_button},
		      ],
	      nowrap: false,
	      showToggleBtn: false,
	  sortname: "id",
	      sortorder: "asc",
	      usepager: true,
	      resizable: false,
	      title: '',
	      useRp: true,
	      rp: 10,
	      showTableToggleBtn: true,
	      height: 200,
	      width: "auto",	
	  pagetext: 'Page',
	  outof: 'of',
	  nomsg: 'No items',
	  procmsg: 'Processing, please wait ...',
	  pagestat: 'Displaying {from} to {to} of {total} items',
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
      });
      </script>   
      
      <script type="text/javascript">
	  $(document).ready(function() {
	  // validate signup form on keyup and submit
	  $("#ip_map").validate({
		  rules: {
			      ip: "required",
			  },
		    messages: {
			      ip: "Please enter Vallid ip address",
			  }
		  });
	  });
      </script>

<script type="text/javascript">
$(document).ready(function() {
	
$("#flex6").flexigrid({
    url: "<?php echo base_url();?>accounts/invoice_json/<?=$account_number?>/",
    method: 'GET',
    dataType: 'json',
	colModel : [			
		{display: 'Invoice Number', name: 'InvoiceNumber', width:220,  sortable: false, align: 'center'},
        {display: 'Invoice Date', name: 'Invoice Date',width:220, sortable: false, align: 'center'},
		{display: 'Invoice Total', name: 'InvoiceTotal',width:220, sortable: false, align: 'center'},
		{display: 'HTML View', name: 'HTMLView',width:220, sortable: false, align: 'center'},
		{display: 'PDF View', name: 'PDFView',width:220, sortable: false, align: 'center'},

		],
    buttons : [
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		],
	nowrap: false,
	showToggleBtn: false,
    sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: false,
	title: '',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	height: 200,
	width: "auto",	
    pagetext: 'Page',
    outof: 'of',
    nomsg: 'No items',
    procmsg: 'Processing, please wait ...',
    pagestat: 'Displaying {from} to {to} of {total} items',
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
        

});
</script>     
      
<script type="text/javascript">
$(document).ready(function() {
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
	    url      : "/accounts/insert_block_pattern/<?=$account_number?>",
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
    url: "<?php echo base_url();?>accounts/block_prefix_json/<?=$account_number?>/",
    method: 'GET',
    dataType: 'json',
	colModel : [
		      {display: '<input type="checkbox" name="chkAll" class="checkall"/>', name : 'chkDelete', width : 45, sortable : false, align: 'left'},		
		      {display: 'Blocked Pattern', name: 'BlockedPattern', width:220,  sortable: false, align: 'center'},
		      {display: 'Action',width:220, name: 'Action', align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'',},}	
		   ],
	buttons :  [
		      {name: 'Refresh', bclass: 'reload', onpress : reload_button},
		      {separator: true},
		      {name: 'Add', bclass: 'add', onpress : add_button},
		      {separator: true},
		      {name: 'Delete Selected', bclass: 'delete', onpress : removeFromList},

		   ],
	nowrap: false,
	showToggleBtn: false,
    sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: false,
	title: 'Bolcked Pattern List',
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
        		loadingImage : '<?php echo base_url();?>/images/loading.gif',
        		closeImage   : '<?php echo base_url();?>/images/closelabel.png'
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
    confirm_string = 'Are you sure want to delete selected Prefixes?';
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
	    url: "/accounts/delete_selected_prefixes/",
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
      } else{
	  alert("Please select atleast one prefixes to delete.");
      }
    }
//     alert(result);  // I will get comma separated selected row ids
  }


    function add_button()
    {
        jQuery.facebox({ ajax: '<?php echo base_url(); ?>accounts/add_block_prefixes/<?=$account_number?>/'});
    }

</script>     
      
<script type="text/javascript">
$(document).ready(function() {
	
$("#flex3").flexigrid({
    url: "<?php echo base_url();?>accounts/dids_json/<?=$account_number?>/",
    method: 'GET',
    dataType: 'json',
	colModel : [			
		{display: 'Number', name: 'Number', width:172,  sortable: false, align: 'center'},
        {display: 'Monthly Fee', name: 'MonthlyFee',width:174, sortable: false, align: 'center'},
        {display: 'Action',width:172, name: '', align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, }, 	
		],
    buttons : [
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		],
	nowrap: false,
	showToggleBtn: false,
    sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: false,
	title: '',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	height: 200,
	width: "auto",	
    pagetext: 'Page',
    outof: 'of',
    nomsg: 'No items',
    procmsg: 'Processing, please wait ...',
    pagestat: 'Displaying {from} to {to} of {total} items',
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
        

});
</script>  

<script type="text/javascript">
$(document).ready(function() {
	
$("#flex2").flexigrid({
    url: "<?php echo base_url();?>accounts/chargelist_json/<?=$account_number?>/",
    method: 'GET',
    dataType: 'json',
	colModel : [
		{display: 'Action',width:31, name: '', align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, }, 		
		{display: 'ID', name: 'ID', width:94,  sortable: false, align: 'center'},
		{display: 'Description', name: 'Description',width:94, sortable: false, align: 'center'},
		{display: 'Cycle', name: 'Cycle',width:106, sortable: false, align: 'center'},
		{display: 'Amount', name: 'Amount',width:141, sortable: false, align: 'center'},		

		],
    buttons : [
		{name: 'Refresh', bclass: 'reload', onpress : reload_button},
		],
	nowrap: false,
	showToggleBtn: false,
    sortname: "id",
	sortorder: "asc",
	usepager: true,
	resizable: false,
	title: '',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	height: 200,
	width: "auto",	
    pagetext: 'Page',
    outof: 'of',
    nomsg: 'No items',
    procmsg: 'Processing, please wait ...',
    pagestat: 'Displaying {from} to {to} of {total} items',
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
        

});
</script>

<script type="text/javascript">
    $(document).ready(function() {
	    
    $("#flex7").flexigrid({
	url: "<?php echo base_url();?>accounts/iax_sip_json/<?=$account_number?>/",
	method: 'GET',
	dataType: 'json',
	    colModel : [			
		    {display: 'Tech', name: 'Tech', width:220,  sortable: false, align: 'center'},
	    {display: 'Type', name: 'Type',width:220, sortable: false, align: 'center'},
		    {display: 'Username', name: 'Username',width:220, sortable: false, align: 'center'},
		    {display: 'Password', name: 'Password',width:220, sortable: false, align: 'center'},
		    {display: 'Context', name: 'Context',width:220, sortable: false, align: 'center'},

		    ],
	buttons : [
		    {name: 'Refresh', bclass: 'reload', onpress : reload_button},
		    ],
	    nowrap: false,
	    showToggleBtn: false,
	sortname: "id",
	    sortorder: "asc",
	    usepager: true,
	    resizable: false,
	    title: '',
	    useRp: true,
	    rp: 10,
	    showTableToggleBtn: true,
	    height: 200,
	    width: "auto",	
	pagetext: 'Page',
	outof: 'of',
	nomsg: 'No items',
	procmsg: 'Processing, please wait ...',
	pagestat: 'Displaying {from} to {to} of {total} items',
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
	    

    });
    </script>     


<script type="text/javascript">
  $(document).ready(function() {
	  
  $("#flex4").flexigrid({
      url: "<?php echo base_url();?>accounts/ani_json/<?=$account_number?>/",
      method: 'GET',
      dataType: 'json',
	  colModel : [			
		  {display: 'ANI/CLID/PREFIX', name: 'ANI/CLID/PREFIX', width:154,  sortable: false, align: 'center'},
	  {display: 'Context - Blank = default', name: 'ContextBlankdefault',width:194, sortable: false, align: 'center'},
	  {display: 'Action',width:172, name: '', align: 'center', formatter:'showlink', formatoptions:{baseLinkUrl:'', }, }, 	
		  ],
      buttons : [
		  {name: 'Refresh', bclass: 'reload', onpress : reload_button},
		  ],
	  nowrap: false,
	  showToggleBtn: false,
      sortname: "id",
	  sortorder: "asc",
	  usepager: true,
	  resizable: false,
	  title: '',
	  useRp: true,
	  rp: 10,
	  showTableToggleBtn: true,
	  height: 200,
	  width: "auto",	
      pagetext: 'Page',
      outof: 'of',
      nomsg: 'No items',
      procmsg: 'Processing, please wait ...',
      pagestat: 'Displaying {from} to {to} of {total} items',
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
	  

  });
</script>
  
<script type="text/javascript">

function reload_button()
{
  $('#flex1').flexReload();
}		
$().ready(function() {
$('#tabs').tabs();
// validate signup form on keyup and submit
$("#signupForm").validate({
      rules: {
	      name: "required",
	      accountno: "required",
	      username: {
		      required: true,
		      minlength: 2
	      },
	      password: {
		      required: true,
		      minlength: 5
	      },
	      password1: {
		      required: true,
		      minlength: 5,
		      equalTo: "#password"
	      },
	      email: {
		      required: true,
		      email: true
	      },
	      topic: {
		      required: "#newsletter:checked",
		      minlength: 2
	      },
      messages: {
	      firstname: "Please enter your firstname",
	      lastname: "Please enter your lastname",
	      username: {
		      required: "Please enter a username",
		      minlength: "Your username must consist of at least 2 characters"
	      },
	      password: {
		      required: "Please provide a password",
		      minlength: "Your password must be at least 5 characters long"
	      },
	      confirm_password: {
		      required: "Please provide a password",
		      minlength: "Your password must be at least 5 characters long",
		      equalTo: "Please enter the same password as above"
	      },
	      email: "Please enter a valid email address",
	      agree: "Please accept our policy"
      }
      }
});
});
</script>
<script type="text/javascript" language="javascript">
function get_alert_msg(id)
{
    confirm_string = 'are you sure to delete?';
    var answer = confirm(confirm_string);
    return answer // answer is a boolean
}
</script>  
<style>
    fieldset{
        width: 609px;
    }
</style>			
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
	
<input type="hidden" value="<?=$account['number']?>" />
<div id="tabs">
	<ul>
		<li><a href="#customer_details">Customer Details</a></li>
		<li><a href="#accounts">Accounts</a></li>
		<li><a href="#packages">Packages</a></li>
		<li><a href="#invoices_payments">Invoices/Payments</a></li>
		<li><a href="#block_prefixes">Block Prefixes</a></li>
<!--  		<li><a href="#cdr_report">CDR Report</a></li>  -->
	</ul>	
<!-- Customer Detail Tab Starts	 -->
	<div id="customer_details">
	      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
	      
	      <div class="portlet-header ui-widget-header"><!--< ?php echo isset($account)?"Edit":"Create New";?> Account-->
    <?=@$page_title?>
    <span class="ui-icon ui-icon-circle-arrow-s"></span></div>
  <div class="portlet-content">
    <form action="<?php echo base_url();?><?=(@$flag =="create")?"accounts/create/":"accounts/edit/"?>" id="createAccount" method="POST" enctype="multipart/form-data">
      <div style="margin:0 auto; width:1050px">
      <div style="width:500px; float:left">
        <div style="width:500px; margin-bottom:10px;">
          <fieldset  style="width:500px;">
            <legend><span style="font-size:14px; font-weight:bold; color:#000; padding:5px;"> Client Panel Access </span></legend>
            <div class="content-box-wrapper">
              <ul>
                <li>
                  <label class="desc">Account Number:</label>
                  <input name="<?php echo (@$flag=='create')?"customnum":"item";?>" type="text" class="text field medium" id="customnum" <?=(@$flag =="create")?"":"readonly='readonly'"?>  value="<?=@$account['number']?>"  size="20"/>
                </li>
                <li>
                  <label class="desc">Password:</label>
                  <input name="accountpassword" type="password" class="text field medium" id="accountpassword"  value="<?=@$account['password']?>"  size="20"/>
                </li>                
              </ul>
            </div>
          </fieldset>
        </div>
        
        <div style="width:500px; margin-bottom:10px;">
          <fieldset  style="width:500px;">
            <legend><span style="font-size:14px; font-weight:bold; color:#000; padding:5px;"> Customer Profile</span></legend>
            <div class="content-box-wrapper">
              <ul>
                <?php if(@$flag == "edit"){?>
                <li>
                  <label class="desc">Reseller:</label>
                  <select name="reseller" class="select field medium">
                    <option value=""></option>
                    <?=$resellers?>
                  </select>
                </li>
                <?php }?>
                <li>
                  <label class="desc">Language:</label>
                  <?=form_languagelist('language',@$account['language'],array("class"=>"select field small"))?>
                </li>
                <li>
                  <label class="desc">Company:</label>
                  <input type="text" class="text field medium" name="company"  size="50" value="<?=@$account['company_name']?>" />
                </li>
                <li>
                  <label class="desc">First Name:</label>
                  <input name="firstname" type="text" class="text field medium" id="firstname"  value="<?=@$account['first_name']?>"  size="50"/>
                </li>
                <li>
                  <label class="desc">Last Name:</label>
                  <input name="lastname" type="text" class="text field medium" id="lastname"  value="<?=@$account['last_name']?>"  size="50"/>
                </li>
                <li>
                  <label class="desc">Telephone1:</label>
                  <input name="telephone1" type="text"  class="text field medium" id="telephone1"  value="<?=@$account['telephone_1']?>"  size="20"/>
                </li>
                <li>
                  <label class="desc">Telephone2:</label>
                  <input name="telephone2" type="text"  class="text field medium" id="telephone2"  value="<?=@$account['telephone_2']?>"  size="20"/>
                </li>
                <li>
                  <label class="desc">Email:</label>
                  <input class="text field medium" type="text" name="email"  size="50"  value="<?=$account['email']?>"/>
                </li>                
                <li>
                  <label class="desc">Address 1:</label>
                  <input name="address1" type="text" class="text field medium" id="address1"  value="<?=@$account['address_1']?>"  size="50"/>
                </li>
                <li>
		    <label class="desc">Address 2:</label>
		    <input name="address2" type="text" class="text field medium" id="address2"  value="<?=@$account['address_2']?>"  size="50"/>
                </li>
                <li>
                  <label class="desc">City:</label>
                  <input class="text field medium" type="text" name="city"  size="20"  value="<?=$account['city']?>"/>
                </li>
                <li>
                  <label class="desc">Province/State:</label>
                  <input class="text field medium" type="text" name="province"  size="20"  value="<?=@$account['province']?>"/>
                </li>
                <li>
                  <label class="desc">Zip/Postal Code:</label>
                  <input type="text" name="postal_code" class="text field medium"  size="20"  value="<?=@$account['postal_code']?>"/>
                </li>
                <li>
                  <label class="desc">Tax ID:</label>
                  <input type="text" name="Tax_ID" class="text field medium"  size="20"  value="<?=@$account['Tax_ID']?>"/>
                </li>
                <li>
                  <label class="desc">Country:</label>
                  <?=form_countries('country',@$account['country'],array("class"=>"select field small"))?>
                </li>
                <li>
                  <label class="desc">Timezone:</label>
                  <?=form_timezone('timezone',$account['tz'],array("class"=>"select field medium"))?>
                </li>
              </ul>
            </div>
          </fieldset>
        </div>
      </div>
      <div style="float:left; width:500px; margin-left:30px;">
        <div style="width:500px; margin-bottom:10px;">
          <fieldset  style="width:500px;">
            <legend><span style="font-size:14px; font-weight:bold; color:#000; padding:5px;"> Account Settings</span></legend>
            <div class="content-box-wrapper">
              <ul>
                <li>
                  <?php
					  $attributes = array("class"=>"select field medium");
					  if(@$flag == "edit")
					  {
					  	$attributes['readonly'] = "readonly"; 
						$attributes['disabled'] = "disabled"; 
					  }
					  
					  ?>
                  <label class="desc">Account Type:</label>
                  <?=form_select_default('accounttype',$user_types,@$account['type'],$attributes)?>
                </li>
                <? //echo "<pre>";print_r($account);echo "</pre>";?>
                <li>
                <label class="desc">Account Status:</label>
                  <select class="select field medium" name="status">
                    <option value="1" <?php if(@$account['status'] == 1){ echo "selected='selected'";}?>>Active</option>
                    <option value="2" <?php if(@$account['status'] == 2){ echo "selected='selected'";}?>>Inactive</option>
                  </select>
		</li>
                <?php 
                if(Common_model::$global_config['system_config']['softswitch']=='0')
		{
                if(!isset($account)){?>
                <li>
                  <label class="desc">Add VOIP Friend:</label>
                  <span>
                  <label for="SIP">
                    <input type="checkbox" name="SIP" value="on" />
                    SIP</label>
                  </span><span>
                  <label for="IAX2">
                    <input type="checkbox" name="IAX2" value="on" />
                    IAX2</label>
                  </span> </li>
                <?php }?>
                <li>
                  <label class="desc">Device Type:</label>
                  <?=form_devicetype('devicetype','friend',array("class"=>"select field medium"))?>
                </li>
                <li>
                  <label class="desc">Context:</label>
                  <input class="field text medium" type="text" name="context" size="20"  value="<?=$config['default_context']?>"/>
                  <!-- default_context --> 
                </li>
                <!--<li>
                      <label class="desc">Fascimile</label><input class="field text medium" type="text" name="fascimile" size="20"  value="<?=$account['fascimile']?>"/>
                      </li>-->
                <li>
                  <label class="desc">IP Address:</label>
                  <input type="text" class="field text medium" name="ipaddr" value="dynamic" size="20" />
                </li>
                <?}else{
		  if(!isset($account)){?>
		  <li>
                  <label class="desc">Add VOIP Friend:</label>
                  <span>                  
                    &nbsp;<input type="checkbox" name="SIP" value="on" />                    
                  </span></li>                  
                <?
		  }
		  ?>
		  <input class="field text medium" type="hidden" name="context" size="20"  value="<?=$config['default_context']?>"/>
		  <?
		  }?>
                <li>
                  <label class="desc">Max Channels:</label>
                  <input type="text" class="text field medium" name="maxchannels"  size="4"  value="<?=$account['maxchannels']?>"/>
                </li>
                <li>
                  <label class="desc">Dialed Number Mods:</label>
                  <input class="text field medium" type="text" name="dialed_modify"  size="20"  value='<?=$account['dialed_modify']?>'/>
                </li>
              </ul>
            </div>
          </fieldset>
        </div>
        <div style="width:500px; margin-bottom:10px;">
          <fieldset  style="width:500px;">
            <legend><span style="font-size:14px; font-weight:bold; color:#000; padding:5px;"> Billing Information </span></legend>
            <div class="content-box-wrapper">
              <ul>
                <li>
                  <label class="desc">Pricelist:</label>
                  <?=form_select_default('pricelist',$pricelist,@$account['pricelist'],array("class"=>"select field medium"))?>
                </li>
                <li>
                  <label class="desc">Billing Schedule:</label>
                  <?=form_select_default('sweep',$sweeplist,@$account['sweep'],array("class"=>"select field medium"))?>
                </li>
                <li>
                  <label class="desc">Currency:</label>
                  <?=form_select_default('currency',$currency_list,@$account['currency'],array("class"=>"select field medium"))?>
                </li>
                <li>
                  <label class="desc">Credit Limit:</label>
                  <input class="text field medium" type="text" name="credit_limit"  size="6"   value="<?=$this->common_model->calculate_currency($account['credit_limit'],'','',true,false)?>"/>
                </li>
                <li>
                  <label class="desc">P.T.E:</label>
                  <select class="select field medium" name="posttoexternal">
                    <option value="1" <?php if(@$account['posttoexternal'] == 1){ echo "selected='selected'";}?>>YES</option>
                    <option value="0" <?php if(@$account['posttoexternal'] == 0){ echo "selected='selected'";}?>>NO</option>
                  </select>
                </li>
              </ul>
            </div>
          </fieldset>
        </div>
      </div>
      <div style="width:100%; float:left;height:40px;margin-top:20px;">
        <input class="ui-state-default float-right ui-corner-all ui-button" type="submit" name="action" value="<?php echo (@$flag=='create')?"Generate Account":"Save..."?>" />
      </div>
    </form>
  </div>
	  </div>          	      
	    </div>
	</div>
	
<!-- Customer Detail Tab Completed -->

<!-- Accounts Tab Starts	 -->
<div id="accounts">
<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">

      <!-- Ip Map Table	 Start-->
      <div class="two-column" style="float:left;width: 100%;">
      <div class="column">
      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">      
        <div class="portlet-header ui-widget-header">IP Address Mapping<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">            
            <div class="hastable" style="margin-bottom:10px;">
		  <table id="flex5" align="left" style="display:none;"></table> 
             </div>
	      <div class="content-box content-box-header ui-corner-all float-left full">
		    <div class="ui-state-default ui-corner-top ui-box-header">
			<span class="ui-icon float-left ui-icon-signal"></span>
			Map IP
		    </div>
		    <div class="content-box-wrapper"> 
		    <div class="sub-form">
		  <form method="post" name="ip_map" id="ip_map" action="<?=base_url()?>accounts/account_detail_add" enctype="multipart/form-data">
		    <input type="hidden" name="accountnum" value="<?=$account['number']?>" />
			<div><label class="desc">IP</label><input class="text field large" name="ip" size="16" type="text"></div>
			<div><label class="desc">Prefix</label><input class="text field large" name="prefix" size="16" type="text"></div>			
			<div><label class="desc">IP Context</label><input class="text field large" name="ipcontext" size="16" type="text"></div>
			<div style="margin-top:14px; width:60px;"><input class="ui-state-default ui-corner-all ui-button" name="action" value="Map IP" type="submit"></div>
		    </form>
		    </div>
		    </div>	      
	    </div>
	</div>           
	</div>
         </div>
	
	<!-- Ip Map Table	 Completed-->    
	<!-- ANI/CLID Table Starts -->
	<div class="column column-right">
	  <!--<div class="column">        -->
	  <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
	  <div class="portlet-header ui-widget-header">ANI & Prefix Mapping - Either enter prefix or ANI/CLID<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
	  <div class="portlet-content">          
          <div class="hastable" style="margin-bottom:10px;">
          <table id="flex4" align="left" style="display:none;"></table>              
              <?php
			  foreach($account_ani_list as $row)
			  {
				  ?>
                  <tr><td><?=$row['number']?></td><td><?=$row['context']?></td><td><a href="">remove</a></td></tr>
                  <?
			  }
              ?>
          </table>
          </div>
          <div class="content-box content-box-header ui-corner-all float-left full" style="position:relative; z-index:9999">
                <div class="ui-state-default ui-corner-top ui-box-header">
                    <span class="ui-icon float-left ui-icon-signal"></span>
                    Map ANI
                </div>
                <div class="content-box-wrapper"> 
                <div class="sub-form">   
                <form method="post" action="<?=base_url()?>accounts/account_detail_add" enctype="multipart/form-data">
                  <input type="hidden" name="accountnum" value="<?=$account['number']?>" />     
                  <div><label class="desc">ANI</label><input class="text field large" name="ANI" size="20" type="text"></div>
                  <div><label class="desc">Context</label><input class="text field large" name="context" size="20" type="text"></div>
                  <div style="margin-top:14px;"><input class="ui-state-default ui-corner-all ui-button" name="action" value="Map ANI" type="submit"></div>
                </form>  
                </div>
                </div>
           </div>
        </div>
      </div>       
<!--     </div>	 -->
      </div>        <!-- ANI/CLID Table	 Completed-->    
      
      <!--   IAX & SIP Table Starts   -->
      <div class="two-column" style="float:left;width: 100%;">
      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">IAX2 & SIP Accounts<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">          
           <div class="hastable" style="margin-bottom:10px;">
            <table id="flex7" align="left" style="display:none;"></table>                 
           </div>
        </div>
      </div>
    </div>
    </div>
     <!--   IAX & SIP Table End   --> 
     </div>
</div>
<!-- Accounts Tab Completed	 -->

<!-- Package table started -->
<div id='packages'>
<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
<!-- Charges table started -->
<div class="two-column" style="float:left;width: 100%;">
    <div class="column">
      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">Charges<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">
         <div class="hastable" style="margin-bottom:10px;">
	  <table id="flex2" align="left" style="display:none;"></table>    
              
         </div>
          <div class="content-box content-box-header ui-corner-all float-left full">
                <div class="ui-state-default ui-corner-top ui-box-header">
                    <span class="ui-icon float-left ui-icon-signal"></span>
                    Add Charge
                </div>
                <div class="content-box-wrapper">
                 <form method="post" action="<?=base_url()?>accounts/account_detail_add" enctype="multipart/form-data">
                 <input name="mode" value="View Details" type="hidden">
                 <input type="hidden" name="accountnum" value="<?=$account['number']?>" />
                 <div class="sub-form">
                 <div>
                 <label class="desc">Applyable Charges</label>
                 <select class="select field large" name="applyable_charges"><? //=$applyable_charges?>
                 <?php 
				 foreach($chargelist as $key => $value){
					 ?>
                     <option value="<?=$key?>"><?=$value?></option>
                     <?
				 }?>
                 </select>
                 </div>
                 <!--<div>
                 <label class="desc">ID</label>
                 <input class="text field large" name="id" size="3" type="text">
                 </div>-->
                 <div style="margin-top:14px;">
                 <input class="ui-state-default ui-corner-all ui-button" name="action" value="Add Charge..." type="submit">
                 </div>
                 </div>
                 </form>
                 </div>
          </div>
         </div>
        </div>       
    </div>
<!--  Charges table completed -->

<!-- DID Table started -->
<div class="column column-right">
      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">DIDs<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">      
          <div class="hastable" style="margin-bottom:10px;">
           <table id="flex3" align="left" style="display:none;"></table>    
         <!-- <table>
          <thead>
              <tr>
                  <td>Number</td>
                  <td>Monthly Fee</td>
                  <td>Action</td>
              </tr>
          </thead>
          
              <? //$account_did_list?>	
              <?php 
			  foreach($account_did_list as $row){
				$cost = $this->common_model->calculate_currency($row['monthlycost']);
			  ?>
              <tr><td><?=$row['number']?></td><td><?=$cost?></td><td><a href="/accounts/did_remove/<?=$row['number']?>">remove</a></td></td></tr>
              <?
			  }?>
          </table>-->
          </div>
		  <div class="content-box content-box-header ui-corner-all float-left full">
                  <div class="ui-state-default ui-corner-top ui-box-header">
                      <span class="ui-icon float-left ui-icon-signal"></span>
                      Add DID
                  </div>
                  <div class="content-box-wrapper">
                  <div class="sub-form"> 
                 <form method="post" action="<?=base_url()?>accounts/account_detail_add" enctype="multipart/form-data">
                   <input name="mode" value="View Details" type="hidden">
                 	<input type="hidden" name="accountnum" value="<?=$account['number']?>" />         
                          <div><label class="desc">Number</label>
                          <select class="select field large" name="did_list">
                          <?php 
						  foreach($availabledids as $key => $value){
							  foreach($value as $newval) {
							  ?>
                              <option value="<?=@$newval?>"><?=@$newval?></option>
                              <?
							  }
							  
						  }?>
						  <? //=$available_dids?>
                         
                          </select></div>
                         <!-- <div><label class="desc">Monthly Fee</label><input class="text field large" name="id" size="3" type="text"></div>-->
                          <div style="margin-top:14px;"><input class="ui-state-default ui-corner-all ui-button" name="action" value="Purchase DID" type="submit"></div>
                          </form>
                  </div>
                  </div>
          </div>

          </div>
      </div>         
    </div>
</div>
<!-- DID Table Completed -->

<!-- Post charge table started -->
<div class="two-column" style="float:left;width: 100%;">
      <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">Post Charge to Account<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">          
          <div class="hastable" style="margin-bottom:10px;">         
          </div>          
            <div class="content-box content-box-header ui-corner-all float-left full">
                  <div class="ui-state-default ui-corner-top ui-box-header">
                      <span class="ui-icon float-left ui-icon-signal"></span>
                      Post Charge
                  </div>
                  <div class="content-box-wrapper"> 
                  <div class="sub-form">
                <form method="post" action="<?=base_url()?>accounts/account_detail_add" enctype="multipart/form-data">
                  <input type="hidden" name="accountnum" value="<?=$account['number']?>" />
                  <div><label class="desc">Description</label><input class="text field large" name="desc" size="16" type="text"></div>
                  <div><label class="desc">Amount</label><input class="text field large" name="amount" size="8" type="text"></div>
                  <div style="margin-top:14px;"><input class="ui-state-default ui-corner-all ui-button" name="action" value="Post Charge..." type="submit"></div>
                  </form>
                  </div>
                  </div>
             </div>
        </div>
      </div>         
</div>
<!-- Post charge table completed -->
</div>
</div>
<!-- Package tab completed -->


<!-- Invoices/Payment tabe started -->
<div id="invoices_payments">

<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">Invoices<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">          
           <div class="hastable" style="margin-bottom:10px;">   
            <table id="flex6" align="left" style="display:none;"></table>                  
           </div>
        </div>
      </div> 
    </div>


<!-- </div> -->
<!-- Invoices tabe completed -->
<!-- Block Prefixes tabe start -->
<div id="block_prefixes">
    <div class="hastable" style="margin-bottom:10px;">   
      <form action="" id="addlist" name="addlist" method="POST" enctype="multipart/form-data" style="display:block">
	<span id="error" style="color:red;">&nbsp;</span><br/>
	<input type="text" id="add_to_list" name="add_to_list">&nbsp;
	<input type="button" id="add_to_list_btn" class="ui-state-default  ui-corner-all ui-button" name="add_to_list_btn" value="Add To List">
      </form>
    </div>
    <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">Block Pattern List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">          
           <div style="margin-bottom:10px;">   
            <table id="flex8" align="left" style="display:none;"></table>                  
           </div>
        </div>
      </div> 
    </div>
  </div>

</div>
<!-- Block Prefixes tabe completed -->


<!-- CDR tabe started -->
<!--<div id="cdr_report">

<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
        <div class="portlet-header ui-widget-header">CDR List<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
        <div class="portlet-content">
           <div class="hastable" style="margin-bottom:10px;">       
           <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">
		<table id="flex1" align="left" style="display:none;"></table>
	    </form>          
           </div>     
        </div>
      </div>           
</div>           
</div>-->
<!--  -->

</div>
	
<?php 
	//echo $form;
?>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>  
