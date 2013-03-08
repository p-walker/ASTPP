<? extend('master.php') ?>

    <? startblock('extra_head') ?><? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
<br/>

<form action="." id="signupForm1" method="POST" enctype="multipart/form-data">
<input type="hidden" name="mode" value="Create CallShop"/>
Please enter the following information to create a new callshop<br>
<table style="text-align: left; width: 100%;" 
 cellpadding="2" cellspacing="2">
  <tbody>
    <tr class='rowone'>
      <td >Call Shop Name</td>
      <td ><input size="10" name="callshop_name"></td>
    </tr>
    <tr  class='rowone'>
      <td >Login Password</td>
      <td ><input size="10" name="accountpassword"></td>
    </tr>
    <tr class='rowone'>
      <td >Credit Limit</td>
      <td ><input size="10" name="credit_limit"></td>
    </tr>
    <tr class='rowone'>
      <td >Sweep</td>
      <td ><TMPL_VAR NAME="sweep"></td>
    </tr>
    <tr class='rowone'>
      <td style='color:white;'>Language</td>
      <td style='color:white;'><TMPL_VAR NAME="language"></td>
    </tr>
    <tr class='rowone'>
      <td >Currency</td>
      <td ><TMPL_VAR NAME="currency"></td>
    </tr>
    <tr class='rowone'>
      <td >Link to OSCommerce Site</td>
      <td ><input size="60"
 value="http://www.companysite.com/store/"
 name="osc_site"></td>
    </tr>
    <tr class='rowone'>
      <td >OSCommerce Database Name</td>
      <td ><input name="osc_dbname"></td>
    </tr>
    <tr class='rowone'>
      <td >OSCommerce Database Host</td>
      <td ><input name="osc_dbhost"></td>
    </tr>
    <tr class='rowone'>
      <td >OSCommerce Database Password</td>
      <td><input name="osc_dbpass" type="password"></td>
    </tr>
    <tr class='rowone'>
      <td >OSCommerce Database Username</td>
      <td><input name="osc_dbuser"></td>
    </tr>
  </tbody>
</table>
<br>
<input type="submit" name="action" value="Add..." />
<br><hr>
<TMPL_VAR NAME= "status">
</form>



<?php 
	//echo $form;
?>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>  
