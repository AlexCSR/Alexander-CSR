<!-- 

# ver: 1.1.1

# Внешние компоненты
# req: /protected/components/DActiveForm.php 1.0, 1.1

# Свой модуль
# req: /protected/modules/pages/controllers/AdminController.php 1.1.1

# req: /protected/modules/pages/views/admin/_form_fields_content.php
# req: /protected/modules/pages/views/admin/_form_fields_settings.php


-->


	<style type="text/css">
		.markItUp {width: 100%;}
	</style>

<!-- ФОРМА СТРАНИЦЫ -->


	<?php $form = $this->beginWidget('DActiveForm', array(
		'id'=>'page-form',
		'stateful' => true,
		'htmlOptions' => array('class' => 'form-horizontal',
								'enctype' => 'multipart/form-data'),
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
	)); ?>

		<fieldset>


			<?php if ($this->settingsAccess): ?>

				<?php $this->widget('bootstrap.widgets.BootTabbable', array(
				   	'type'=>'tabs', // 'tabs' or 'pills'
					'tabs'=>array(
						array('label' => 'Контент', 'content' => $this->renderPartial('_form_fields_content', array('form' => $form, 'modPage' => $modPage), true), 'active' => true),
						array('label' => 'English', 'content' => $this->renderPartial('_form_fields_english', array('form' => $form, 'modPage' => $modPage), true)),	
						array('label' => 'Администрирование', 'content' => $this->renderPartial('_form_fields_settings', array('form' => $form, 'modPage' => $modPage), true)),	
					),
				)); ?>

			<?php else: ?>

				<?php $this->renderPartial('_form_fields_content', array('form' => $form, 'modPage' => $modPage)) ?>
				
			<?php endif ?>




			
		</fieldset>



		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => $this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>		
			<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>

			<?php $this->widget('bootstrap.widgets.BootButton', array(
									'buttonType'=>'button', 
									'type'=>'info', 
									'icon'=>'refresh white', 
									'label'=>'Применить', 
									'htmlOptions' => array('onclick' => 'jQuery("#refresh").val(1); jQuery("#page-form").submit();'))); ?>		


			<?php echo CHtml::hiddenField('refresh', 0, array('id' => 'refresh')) ?>


		</div>


	<?php $this->endWidget(); ?>
