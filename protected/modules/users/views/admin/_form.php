<!-- 
 # ver: 1.2.0
-->

<?php $form = $this->beginWidget('DActiveForm', array(
	'id'=>'user-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'focus' => array($modUser, 'name'),
)); ?>

	<fieldset>
		<div class="control-group">
			<div class='controls'>          
				<?php if(count($modUser->errors) > 0): ?>
					<div class="span12 alert alert-error">
					 <?php echo $form->errorSummary($modUser); ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	 
		<!-- NAME -->
		<div class="control-group <?php if (isset($modUser->errors['name'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modUser, 'name', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modUser, 'name', array('class' => 'span12')); ?>
				<?php echo $form->error($modUser, 'name', array('class' => 'help-block')); ?>
			</div>
		</div>
	 

	
		<div class='row-fluid'>

			<div class='span6'>
				<!-- LOGIN -->
				<div class="control-group <?php if (isset($modUser->errors['login'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modUser, 'login', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->textField($modUser, 'login', array('class' => 'span12')); ?>
						<?php echo $form->error($modUser, 'login', array('class' => 'help-block')); ?>
					</div>
				</div>				
			</div>

			<div class='span6'>
				<!-- EMAIL -->
				<div class="control-group <?php if (isset($modUser->errors['email'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modUser, 'email', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->textField($modUser, 'email', array('class' => 'span12')); ?>
						<?php echo $form->error($modUser, 'email', array('class' => 'help-block')); ?>
					</div>
				</div>
			</div>
		</div>


		<?php if (Yii::app()->user->checkAccess('/users/admin/update')): ?>

			<?php if ($modUser->isNewRecord): ?>
				<!-- password -->
				<div class="control-group <?php if (isset($modUser->errors['password'])) echo 'error'; ?> ">
					<?php echo $form->labelEx($modUser, 'password', array('class' => 'control-label')); ?>
					<div class='controls'>
						<?php echo $form->textField($modUser, 'password', array('class' => 'span12')); ?>
						<?php echo $form->error($modUser, 'password', array('class' => 'help-block')); ?>
					</div>
				</div>
			<?php endif ?>


			<div class='row-fluid'>
				<div class='span6'>
					<!-- URL_ROLE -->
					<div class="control-group <?php if (isset($modUser->errors['url_role'])) echo 'error'; ?> ">
						<?php echo $form->labelEx($modUser, 'url_role', array('class' => 'control-label')); ?>
						<div class='controls'>
							<?php echo $form->dropDownList($modUser, 'url_role', $modUser->enum_url_role, array('class' => 'span12')); ?>
							<?php echo $form->error($modUser, 'url_role', array('class' => 'help-block')); ?>
						</div>
					</div>			
				</div>

				<div class='span6'>
					<!-- Активен -->
					<div class="control-group <?php if (isset($modUser->errors['flg_active'])) echo 'error'; ?> ">
						<?php echo $form->labelEx($modUser, 'flg_active', array('class' => 'control-label')); ?>
						<div class='controls'>
							<?php echo $form->checkBox($modUser, 'flg_active', array('class' => '')); ?>
							<?php echo $form->error($modUser, 'flg_active', array('class' => 'help-block')); ?>
						</div>
					</div>			
				</div>
			</div>
		<?php endif ?>

	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>		
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>


<?php $this->endWidget(); ?>
