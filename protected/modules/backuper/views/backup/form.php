<?php 

	# ver: 1.0.0

?>

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'backup-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'focus' => array($modBackup, 'name'),
)); ?>


<fieldset>

	<div class="control-group">
		<div class='controls'>          
			<?php if(count($modBackup->errors) > 0): ?>
				<div class="span12 alert alert-error">
				 <?php echo $form->errorSummary($modUser); ?>
				</div>
			<?php endif ?>
		</div>
	</div>


	<div class='row-fluid'>
		<div class='span8'>
			<!-- NAME -->
			<div class="control-group <?php if (isset($modBackup->errors['name'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modBackup, 'name', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->textField($modBackup, 'name', array('class' => 'span12')); ?>
					<?php echo $form->error($modBackup, 'name', array('class' => 'help-block')); ?>
				</div>
			</div>
		</div>

		<div class='span4'>
			<!-- NAME -->
			<div class="control-group <?php if (isset($modBackup->errors['url_type'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modBackup, 'url_type', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->dropDownList($modBackup, 'url_type', $modBackup->enum_url_type,  array('class' => 'span12')); ?>
					<?php echo $form->error($modBackup, 'url_type', array('class' => 'help-block')); ?>
				</div>
			</div>
		</div>
	</div>

	<!-- NAME -->
	<div class="control-group <?php if (isset($modBackup->errors['tables'])) echo 'error'; ?> ">
		<?php echo $form->labelEx($modBackup, 'tables', array('class' => 'control-label')); ?>
		<div class='controls'>
			<?php echo $form->checkBoxList($modBackup, 'tables', array_combine($modBackup->enumTables, $modBackup->enumTables),  array('checkAll' => 'Выбрать все', 'template' => '{beginLabel}{input}{labelTitle}{endLabel}', 'labelOptions' => array('class' => 'checkbox'), 'class' => '')); ?>
			<?php echo $form->error($modBackup, 'tables', array('class' => 'help-block')); ?>
		</div>
	</div>

</fieldset>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>		
	<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
</div>



<?php $this->endWidget(); ?>

