<?php 
	# ver: 1.0.0
?>
<style type="text/css">
	.bug-priority-2 .bug-priority {color: red; font-weight: bold;}
	.bug-state-0 .bug-state {color: red; font-weight: bold;} 
	.bug-state-10 .bug-state {color: blue; font-weight: bold;} 
	.bug-state-20 .bug-state {color: green; font-weight: bold;} 
	.bug-state-25 .bug-state {font-style: italic;} 

</style>


<?php $form=$this->beginWidget('CActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'htmlOptions' => array('style' => 'margin-bottom: 0;', 'class' => 'form-horizontal'),
)); ?>
	<div class='well well-small' style='padding-right: 130px; margin-bottom: 0;'>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'icon-search icon-white', 'label'=>'Искать', 'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -120px; width: 100px;'))); ?> 
		

		<div class='row-fluid' style='margin-bottom: 0;'>
			<div class='span9'>
				<?php echo $form->textField($modBug, 'request', array('style' => 'margin-bottom: 0; width: 100%;', 'placeholder' => 'Введите фразу для поиска')); ?>
			</div>
			

			<div class='span3'>
				<div class="control-group" style='margin-bottom: 0;'>
					<label class="control-label" for="Bug_request_new">Показывать закрытые</label>
					<div class='controls'>
						<?php echo $form->checkBox($modBug, 'request_new', array('class' => '')); ?>
					</div>
				</div>
			</div>
		</div>

	</div>
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'id' => 'bug-grid',
	'dataProvider' => $modBug->search(),
	'type'=>'striped bordered hover',
	'template' => '{items}{pager}',
	'selectableRows' => 0,
	'ajaxUpdate' => false,
	'rowCssClassExpression' => '"bug-state-" . $data->id_state . " " . "bug-priority-" . $data->id_priority',
	'columns'=>array(
		array('name' => 'id', 'type' => 'raw', 'value' => '($data->id_priority == 1 ? "<span class=\"label label-important\" style=\"pull-left\">!</span> " : "") . $data->id', 'htmlOptions' => array('style' => 'width: 40px; text-align: right;')),
		array('name' => 'id_state', 'value' => '$data->enum["id_state"]', 'htmlOptions' => array('style' => 'width: 100px;', 'class' => 'bug-state')),
		array('name' => 'name', 'htmlOptions' => array()),
		array('name' => 'id_type', 'value' => '$data->enum["id_type"]', 'htmlOptions' => array('style' => 'width: 100px;')),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{view}',
			'htmlOptions' => array('style' => 'text-align: center;'),
			'buttons' => array(


			),
		),
	),
)); ?>

