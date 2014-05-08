
<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'banner-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
)); ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modBanner->errors) > 0): ?>
					<div class="span10 alert alert-error">
					 <?php echo $form->errorSummary($modBanner); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
	 
		<!-- name -->
		<div class="control-group <?php if (isset($modBanner->errors['name'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBanner, 'name', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modBanner, 'name', array('class' => 'span12')); ?>
				<?php echo $form->error($modBanner, 'name', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- LINK -->
		<div class="control-group <?php if (isset($modBanner->errors['link'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBanner, 'link', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modBanner, 'link', array('class' => 'span12')); ?>
				<?php echo $form->error($modBanner, 'link', array('class' => 'help-block')); ?>
			</div>
		</div>

		<!-- ID_IMAGE -->
		<div class="control-group <?php if (isset($modBanner->errors['id_image'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBanner, 'id_image', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->uploadImage($modBanner, 'id_image', array('class' => 'span12')); ?>
				<?php echo $form->error($modBanner, 'id_image', array('class' => 'help-block')); ?>
			</div>
		</div>
	 
		<!-- DESCRIPTION -->
		<div class="control-group <?php if (isset($modBanner->errors['description'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modBanner, 'description', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textArea($modBanner, 'description', array('class' => 'span12', 'style' => 'height: 200px;')); ?>
				<?php echo $form->error($modBanner, 'description', array('class' => 'help-block')); ?>
			</div>
		</div>

	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>
