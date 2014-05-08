<?php 
	# ver: 1.0.0
?>

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'message-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
)); ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modMessage->errors) > 0): ?>
					<div class="span10 alert alert-error">
					 <?php echo $form->errorSummary($modMessage); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
		<!-- ID_BUG -->
		<div class="control-group <?php if (isset($modMessage->errors['id_bug'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modMessage, 'id_bug', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modMessage, 'id_bug', array('class' => 'span12')); ?>
				<?php echo $form->error($modMessage, 'id_bug', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- ID_USER -->
		<div class="control-group <?php if (isset($modMessage->errors['id_user'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modMessage, 'id_user', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modMessage, 'id_user', array('class' => 'span12')); ?>
				<?php echo $form->error($modMessage, 'id_user', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- TIME -->
		<div class="control-group <?php if (isset($modMessage->errors['time'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modMessage, 'time', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modMessage, 'time', array('class' => 'span12')); ?>
				<?php echo $form->error($modMessage, 'time', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- TEXT -->
		<div class="control-group <?php if (isset($modMessage->errors['text'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modMessage, 'text', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textArea($modMessage, 'text', array('class' => 'span12')); ?>
				<?php echo $form->error($modMessage, 'text', array('class' => 'help-block')); ?>
			</div>
		</div>
		
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>
