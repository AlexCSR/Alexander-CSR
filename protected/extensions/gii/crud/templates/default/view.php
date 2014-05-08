<?php
# ver: 1.0.0

/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$mod<?php echo $this->modelClass ?>,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
