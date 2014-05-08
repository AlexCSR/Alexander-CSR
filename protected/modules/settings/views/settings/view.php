<!-- 

# ver: 1.1.0.1
# req: /protected/modules/settings/controllers/SettingsController.php 1.1

-->



<?php $form=$this->beginWidget('DActiveForm', array(
	'htmlOptions' => array('class' => 'form-horizontal',
						 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,

)); ?>

	<fieldset>




	<div class="control-group">
		<div class='controls'>          
			<?php if(count($modSettings->errors) > 0): ?>
			<div class="span12 alert alert-error">
			 <?php echo $form->errorSummary($modSettings); ?>
			</div>
			<?php endif ?>
		</div>
	</div>

	<?php if (Yii::app()->settings->hasTabs): ?>
		
		<ul class="nav nav-tabs">
			<?php $i = 0 ?>
			<?php foreach (Yii::app()->settings->tabs as $label => $arrProps): ?>
				<li class="<?php if ($i == 0) echo 'active' ?>"><a href="#tab-<?php echo $i ?>" data-toggle="tab"><?php echo $label ?></a></li>
				<?php $i++ ?>
			<?php endforeach ?>
		</ul>


		<div class="tab-content">
			<?php $i = 0 ?>			
			<?php foreach (Yii::app()->settings->tabs as $label => $arrProps): ?>
				<div class="tab-pane <?php if ($i == 0) echo 'active' ?>" id="tab-<?php echo $i ?>">
				<?php foreach ($arrProps as $key => $value): ?>
					<div class="control-group <?php if (isset($modSettings->errors[$key])) echo 'error'; ?> ">
						<?php echo $form->labelEx($modSettings, $key, array('class' => 'control-label')); ?>
						<div class='controls'>
						<?php echo $form->textField($modSettings, $key, array('class' => 'span12')); ?>
						<?php echo $form->error($modSettings, $key, array('class' => 'help-block')); ?>
						</div>
					</div>		
				<?php endforeach ?>	
				</div>	
				<?php $i++ ?>				
			<?php endforeach ?>			
		</div>


	<?php else: ?>
		<?php foreach (Yii::app()->settings->settingsEnum as $key => $value): ?>
			<div class="control-group <?php if (isset($modSettings->errors[$key])) echo 'error'; ?> ">
				<?php echo $form->labelEx($modSettings, $key, array('class' => 'control-label')); ?>
				<div class='controls'>
				<?php echo $form->textField($modSettings, $key, array('class' => 'span12')); ?>
				<?php echo $form->error($modSettings, $key, array('class' => 'help-block')); ?>
				</div>
			</div>		
		<?php endforeach ?>	
	<?php endif ?>


		
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>		
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>
	</div>

<?php $this->endWidget(); ?>
