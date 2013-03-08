<? extend('master.php') ?>

	<? startblock('extra_head') ?>
	<? endblock() ?>

    <? startblock('page-title') ?>
        <?=$page_title?><br/>
    <? endblock() ?>
    
	<? startblock('content') ?>
<br/><br/><br/>

<form method="post" action="." enctype="multipart/form-data">
<input name="mode" value="Remove Account" type="hidden">
<table class="default" width='40%'>
<tr class="header">
	<td colspan=3>Please select the account you wish to remove</td>
</tr>
<tr class='rowone'>
	<td width="10%">
		<select name="accountlist_menu"><?=$accountlist?></select>
	</td>
	<td width="10%">
		<input name="number" size="20" type="text">
	</td>
	<td>
		<input name="action" value="Remove Account" type="submit">
	</td>
</tr>
<tr>
        <td colspan='3' align='center'>
                <?=$status?>
        </td>
</tr>

</table>
</form>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<?php 
	//echo $form;
?>
    <? endblock() ?>
	
    <? startblock('sidebar') ?>
    Filter by
    <? endblock() ?>
    
<? end_extend() ?>  
