<!-- 
	# ver: 1.0.0
-->

<div class='row-fluid'>

	<div class='span2'></div>
	<div class='span8'>


		<div class='well' style='margin-top: 30px;'>


			<h2 style='margin-bottom: 30px !important;'>Вход в систему</h2>

			<?php $form = $this->beginWidget('DActiveForm', array(
				'id'=>'file-form',
				'stateful' => false,
				'htmlOptions' => array('class' => 'form-horizontal',
										'enctype' => 'multipart/form-data',
										'style' => 'margin-bottom: 0;'),
				'enableAjaxValidation' => false,
				'enableClientValidation' => false,
				'focus' => array($modLogin, 'login'),
			)); ?>

			<div class="control-group <?php if (isset($modLogin->errors['login'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modLogin, 'login', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->textField($modLogin, 'login', array('class' => 'span10')); ?>
					<?php echo $form->error($modLogin, 'login', array('class' => 'help-block')); ?>
				</div>
			</div>

			<div class="control-group <?php if (isset($modLogin->errors['password'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modLogin, 'password', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->passwordField($modLogin, 'password', array('class' => 'span10')); ?>
					<?php echo $form->error($modLogin, 'password', array('class' => 'help-block')); ?>
				</div>
			</div>

			<div class="control-group <?php if (isset($modLogin->errors['rememberMe'])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modLogin, 'rememberMe', array('class' => 'control-label')); ?>
				<div class='controls'>
					<?php echo $form->checkBox($modLogin, 'rememberMe'); ?>
					<?php echo $form->error($modLogin, 'rememberMe', array('class' => 'help-block')); ?>
				</div>
			</div>
			
			<div class="form-actions" style='margin-bottom: 0; padding-bottom: 0;'>
				<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'htmlOptions' => array('style' => 'width: 150px;'), 'icon'=>'ok white', 'label'=>'Войти')); ?>
			</div>

				
			<?php $this->endWidget(); ?>


		</div>


	</div>

</div>


