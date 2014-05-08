<?php 

	# ver: 1.0.0

?>


<?php 
	
	$this->widget('bootstrap.widgets.BootDetailView', array(
	'data' => $model,
	'attributes'=> array('name', 'date:datetime', 'user'),
)); 
?>

<table class='table table-bordered table-striped' style='width: 300px; margin: 0px auto;'>
	<tr>
		<th>Таблица</th>
		<th style='width: 20px;'>&nbsp;</th>
	</tr>


	<?php foreach ($model->enumTables as $strTable): ?>
	<tr>
		<td><?php echo $strTable; ?></td>
		<td>
			<?php if (in_array($strTable, $model->tables)): ?>
				<i class='icon-ok'></i>
			<?php endif; ?>
		</td>
	</tr>
	
	<?php endforeach; ?>
</table>
