<!-- 
	# ver: 1.2.0
-->


<?php $form=$this->beginWidget('CActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'htmlOptions' => array('style' => 'margin-bottom: 0;'),
)); ?>
	<div class='well well-small' style='padding-right: 130px; margin-bottom: 0;'>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'icon-search icon-white', 'label'=>'Искать', 'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -120px; width: 100px;'))); ?> 
		<?php echo $form->textField($modUser, 'request', array('style' => 'margin-bottom: 0; width: 100%;')); ?> 
	</div>
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'id'=>'user-grid',
	'dataProvider' => $modUser->search(),
	'type'=>'striped bordered',
	'template' => '{items}{pager}',
	'ajaxUpdate' => false,
	'columns'=>array(
		'name',
		'email',
		array('name' => 'enum.url_role', 'htmlOptions' => array('style' => 'width: 100px;')),
		array('name' => 'flg_active', 'type' => 'boolean', 'htmlOptions' => array('style' => 'width: 100px;')),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{view}',
		),
	),
)); ?>
