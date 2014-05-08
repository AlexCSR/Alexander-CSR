<?php 
	# ver: 1.0.0
?>

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'bug-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'focus' => array($modBug, 'name'),
)); ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modBug->errors) > 0): ?>
					<div class="span10 alert alert-error">
					 <?php echo $form->errorSummary($modBug); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
		<!-- NAME -->
		<div class="control-group <?php if (isset($modBug->errors['name'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBug, 'name', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modBug, 'name', array('class' => 'span12')); ?>
				<?php echo $form->error($modBug, 'name', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- URL -->
		<div class="control-group <?php if (isset($modBug->errors['url'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBug, 'url', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modBug, 'url', array('class' => 'span12')); ?>
				<?php echo $form->error($modBug, 'url', array('class' => 'help-block')); ?>
			</div>
		</div>
	 

		<div class='row-fluid'>
			<div class='span4'>
				<!-- id_type -->
				<div class="control-group <?php if (isset($modBug->errors['id_type'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'id_type', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->dropDownList($modBug, 'id_type', $modBug->enum_id_type, array('class' => 'span12')); ?>
						<?php echo $form->error($modBug, 'id_type', array('class' => 'help-block')); ?>
					</div>
				</div>
			</div>

			<div class='span4'>
				<!-- ID_STATE -->
				<div class="control-group <?php if (isset($modBug->errors['id_state'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'id_state', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->dropDownList($modBug, 'id_state', $modBug->enum_id_state, array('class' => 'span12')); ?>
						<?php echo $form->error($modBug, 'id_state', array('class' => 'help-block')); ?>
					</div>
				</div>
			</div>
			<div class='span4'>
				<!-- ID_PRIORITY -->
				<div class="control-group <?php if (isset($modBug->errors['id_priority'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'id_priority', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->checkBox($modBug, 'id_priority', array()); ?>
						<?php echo $form->error($modBug, 'id_priority', array('class' => 'help-block')); ?>
					</div>
				</div>
			</div>			
		</div>

	 


	 
		<!-- DESCRIPTION -->
		<div class="control-group <?php if (isset($modBug->errors['description'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBug, 'description', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textArea($modBug, 'description', array('class' => 'span12', 'style' => 'height: 300px;')); ?>
				<?php echo $form->error($modBug, 'description', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<div class='row-fluid'>
			<div class='span4'>

				<!-- ID_USER -->
				<div class="control-group <?php if (isset($modBug->errors['id_user'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'id_user', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->dropDownList($modBug, 'id_user', array('' => 'Укажите пользователя') + User::model()->getNames(), array('class' => 'span12')); ?>
						<?php echo $form->error($modBug, 'id_user', array('class' => 'help-block')); ?>
					</div>
				</div>

			</div>
			<div class='span4'>

				<!-- TIME_DETECTED -->
				<div class="control-group <?php if (isset($modBug->errors['time_detected'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'time_detected', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->dateField($modBug, 'time_detected', 0, array('class' => 'span12')); ?>
						<?php echo $form->error($modBug, 'time_detected', array('class' => 'help-block')); ?>
					</div>
				</div>

			</div>
			<div class='span4'>


				<!-- TIME_DONE -->
				<div class="control-group <?php if (isset($modBug->errors['time_done'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modBug, 'time_done', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->dateField($modBug, 'time_done', 0, array('class' => 'span12')); ?>
						<?php echo $form->error($modBug, 'time_done', array('class' => 'help-block')); ?>
					</div>
				</div>

			</div>

		</div>
	 

		
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>
