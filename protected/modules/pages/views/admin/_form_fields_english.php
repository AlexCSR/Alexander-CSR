<!-- 
	# ver: 1.1.p.1

	# Imperavi
	# req: /protected/extensions/imperavi/ImperaviRedactorWidget.php 1.2

-->

<div class="control-group">
	<div class='controls'>          
		<?php if(count($modPage->errors) > 0): ?>
			<div class="span12 alert alert-error">
			 <?php echo $form->errorSummary($modPage); ?>
			</div>
		<?php endif ?>
	</div>
</div>

	

<!-- title_en -->
<div class="control-group <?php if (isset($modPage->errors['title_en'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'title_en', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php echo $form->textField($modPage, 'title_en', array('class' => 'span12', 'disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
		<?php echo $form->error($modPage, 'title_en', array('class' => 'help-block')); ?>
	</div>
</div>



<!-- content_en -->
<div class="control-group <?php if (isset($modPage->errors['content_en'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'content_en', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php $this->widget('ext.imperavi.ImperaviRedactorWidget', array(
			// You can either use it for model attribute
			'model' => $modPage,
			'attribute' => 'content_en',

			// Some options, see http://imperavi.com/redactor/docs/
			'options' => array(
				'lang' => 'ru',
				'toolbar' => true,
				'iframe' => true,
				'imageUpload' => Yii::app()->createUrl('/files/filesWidget/uploadImperavi', array('id_page' => $modPage->id)),
				'fileUpload' => Yii::app()->createUrl('/files/filesWidget/uploadFileImperavi', array('id_page' => $modPage->id)),

				// 'css' => 'wym.css',
			),
			'htmlOptions' => array(
				'style' => 'height: 400px;',
				)
		)); ?>

		<?php echo $form->error($modPage, 'content_en', array('class' => 'help-block')); ?>
	</div>
</div>



<!-- description_en -->
<div class="control-group <?php if (isset($modPage->errors['description_en'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'description_en', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php echo $form->textArea($modPage, 'description_en', array('class' => 'span12', 'style' => 'height: 100px;', 'disabled' => $modPage->flg_block_text ? 'disabled' : '' )); ?>
		<?php echo $form->error($modPage, 'description_en', array('class' => 'help-block')); ?>
	</div>
</div>							


