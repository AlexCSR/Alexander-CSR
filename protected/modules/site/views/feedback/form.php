<div class='w-text'>

		<?php $strIndex = Page::model()->findByAlias('contacts') ?>
		<?php $this->pageTitle = $strIndex->getTitle() ?>
		<?php echo $strIndex->getContent() ?>



	<?php $form=$this->beginWidget('DActiveForm', array(
		'id'=>'feedback-form',
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'w-feedback'),
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>false,

	)); ?>

			 
		<p class="w-feedback-required">Поля отмеченные символом <span class="required">*</span> являются обязательными для заполнения</p>


		<div class="control-group <?php if (isset($modFeedback->errors['name'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modFeedback, 'name', array('class' => 'control-label')); ?>
			<div class='controls'>
				<div class="input name  <?php if (isset($modFeedback->errors['name'])) echo 'error'; ?>">
					<?php echo $form->textField($modFeedback, 'name', array('class' => 'span12')); ?>
				</div>
				<?php echo $form->error($modFeedback, 'name', array('class' => 'help-block')); ?>
			</div>
		</div>


		<div class="control-group <?php if (isset($modFeedback->errors['email'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modFeedback, 'email', array('class' => 'control-label')); ?>
			<div class='controls'>
				<div class="input email  <?php if (isset($modFeedback->errors['email'])) echo 'error'; ?>">
					<?php echo $form->textField($modFeedback, 'email', array('class' => 'span12')); ?>
				</div>
				<?php echo $form->error($modFeedback, 'email', array('class' => 'help-block')); ?>
			</div>
		</div>


		<div class="control-group <?php if (isset($modFeedback->errors['phone'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modFeedback, 'phone', array('class' => 'control-label')); ?>
			<div class='controls'>
				<div class="input phone  <?php if (isset($modFeedback->errors['phone'])) echo 'error'; ?>">
					<?php echo $form->textField($modFeedback, 'phone', array('class' => 'span12')); ?>
				</div>
				<?php echo $form->error($modFeedback, 'phone', array('class' => 'help-block')); ?>
			</div>
		</div>

		<div class="control-group <?php if (isset($modFeedback->errors['text'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modFeedback, 'text', array('class' => 'control-label')); ?>
			<div class='controls'>
				<div class="input message  <?php if (isset($modFeedback->errors['text'])) echo 'error'; ?>">
					<?php echo $form->textArea($modFeedback, 'text', array('class' => 'span12')); ?>
				</div>
				<?php echo $form->error($modFeedback, 'text', array('class' => 'help-block')); ?>
			</div>
		</div>

		<div class="control-group captcha <?php if (isset($modFeedback->errors['verifyCode'])) echo 'error'; ?>" > 
			<label class="control-label required" for="captcha">Текст с картинки <span class="required">*</span></label> 
			<div class="controls">
				<div class="input captcha <?php if (isset($modFeedback->errors['verifyCode'])) echo 'error'; ?>"><?php echo $form->textField($modFeedback, 'verifyCode', array('class' => 'input_capcha')); ?></div>



				<?php $this->widget('CCaptcha', array(
									'showRefreshButton' => false,
									'clickableImage' => true,
									'imageOptions' => array('style' => '')))?>
			
				<?php echo $form->error($modFeedback, 'verifyCode', array('class' => 'help-block')); ?>

			</div> 
		</div> 

		<div class="w-feedback-submit">
			<div class="button"><input type="submit" value=""><span><?php echo Yii::t('site', 'Отправить сообщение') ?></span></div>
		</div>

<?php $this->endWidget(); ?>


</div>
