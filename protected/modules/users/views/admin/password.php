<!-- 
	# ver: 1.1.0
-->

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'user-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'focus' => array($modPassword, 'password'),

)); ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modPassword->errors) > 0): ?>
					<div class="span10 alert alert-error">
					 <?php echo $form->errorSummary($modPassword); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
		<div class="control-group <?php if (isset($modPassword->errors['password'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modPassword, 'password', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->passwordField($modPassword, 'password', array('class' => 'span10')); ?>
					<?php echo $form->error($modPassword, 'password', array('class' => 'help-block')); ?>
				</div>
		</div>
	
		<div class="control-group <?php if (isset($modPassword->errors['confirm'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modPassword, 'confirm', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->passwordField($modPassword, 'confirm', array('class' => 'span10')); ?>
					<?php echo $form->error($modPassword, 'confirm', array('class' => 'help-block')); ?>
				</div>
		</div> 
		
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>    
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>

