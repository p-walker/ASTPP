<? extend('master.php') ?>

	<? startblock('extra_head') ?>
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
<br/>

<form action="." id="signupForm1" method="POST" enctype="multipart/form-data">
<table width='40%'>
<tr>
<td width="10%">Card Number</td>
<td><input type="text" name="cardnumber"  size="20" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="action" value="Reset" /></td>
</tr>
</table>

</form>



<?php 
	//echo $form;
?>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>