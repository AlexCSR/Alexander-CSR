<!-- 

	# ver: 1.0.1

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

<!-- alias -->
<div class="control-group <?php if (isset($modPage->errors['alias'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'alias', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php echo $form->textField($modPage, 'alias', array('class' => 'span12')); ?>
		<?php echo $form->error($modPage, 'alias', array('class' => 'help-block')); ?>
	</div>
</div>

<!-- template -->
<div class="control-group <?php if (isset($modPage->errors['template'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'template', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php echo $form->dropDownList($modPage, 'template', $modPage->arrTemplates, array('class' => 'span12')); ?>
		<?php echo $form->error($modPage, 'template', array('class' => 'help-block')); ?>
	</div>
</div>

<!-- areas -->
<div class="control-group <?php if (isset($modPage->errors['areas'])) echo 'error'; ?> ">
	<?php echo $form->labelEx($modPage, 'areas', array('class' => 'control-label')); ?>
	<div class='controls'>
		<?php echo $form->textArea($modPage, 'areas', array('class' => 'span12', 'style' => 'height: 100px;')); ?>
		<?php echo $form->error($modPage, 'areas', array('class' => 'help-block')); ?>
	</div>
</div>			

<div class='row-fluid'>

	<div class='span3'>						
		<!-- flg_folder -->
		<div class="control-group <?php if (isset($modPage->errors['flg_folder'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_folder', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_folder'); ?>
				<?php echo $form->error($modPage, 'flg_folder', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>

	<div class='span3'>
		<!-- flg_block_header -->
		<div class="control-group <?php if (isset($modPage->errors['flg_block_header'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_block_header', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_block_header'); ?>
				<?php echo $form->error($modPage, 'flg_block_header', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>

	<div class='span3'>
		<!-- flg_block_text -->
		<div class="control-group <?php if (isset($modPage->errors['flg_block_text'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_block_text', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_block_text'); ?>
				<?php echo $form->error($modPage, 'flg_block_text', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>


	<div class='span3'>
		<!-- flg_markdown -->
		<div class="control-group <?php if (isset($modPage->errors['flg_markdown'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_markdown', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_markdown'); ?>
				<?php echo $form->error($modPage, 'flg_markdown', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>
</div>
