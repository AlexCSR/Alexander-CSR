<?php
# ver: 1.0.1.1

/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'action' => Yii::app()->createUrl(\$this->route),
	'method' => 'get',
	'htmlOptions' => array('style' => 'margin-bottom: 0;'),
)); ?>\n"; ?>
	<div class='well well-small' style='padding-right: 130px; margin-bottom: 0;'>
		<?php echo "<?php \$this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'icon-search icon-white', 'label'=>'Искать', 'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -120px; width: 100px;'))); ?> \n"?>
		<?php echo "<?php echo \$form->textField(\$mod{$this->modelClass}, 'request', array('style' => 'margin-bottom: 0; width: 100%;')); ?> \n" ?>
	</div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider' => $mod<?php echo $this->modelClass; ?>->search(),
	'type'=>'striped bordered',
	'template' => '{items}{pager}',
	'selectableRows' => 0,
	'filter' => $mod<?php echo $this->modelClass; ?>,
	'ajaxUpdate' => false,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\tarray('name' => '".$column->name."', 'htmlOptions' => array()),\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{view} {update} {delete}',
			'htmlOptions' => array(),
			'buttons' => array(


			),
		),
	),
)); ?>
