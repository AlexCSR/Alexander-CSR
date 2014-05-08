<!-- 

# ver: 1.1.0

-->

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'file-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'focus' => array($modFile, 'name'),
)); ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modFile->errors) > 0): ?>
					<div class="span12 alert alert-error">
					 <?php echo $form->errorSummary($modFile); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
		<!-- NAME -->
		<div class="control-group <?php if (isset($modFile->errors['name'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modFile, 'name', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modFile, 'name', array('class' => 'span12')); ?>
				<?php echo $form->error($modFile, 'name', array('class' => 'help-block')); ?>
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>		
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>
