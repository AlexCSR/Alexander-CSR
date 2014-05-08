<?php 
	# ver: 1.0.0
?>
<div class='row-fluid'>

	<div class='span8'>
		<?php $this->widget('bootstrap.widgets.BootDetailView', array(
			'data'=>$modBug,
			'attributes'=>array(
				'url:url',
				'id_priority:boolean',

			),
		)); ?>
	</div>

	<div class='span4'>
		<?php $this->widget('bootstrap.widgets.BootDetailView', array(
			'data'=>$modBug,
			'attributes'=>array(
				'user.name:text:Пользователь',
				'time_detected:date',
			),
		)); ?>
	</div>


</div>

<?php if ($modBug->description != ''): ?>
	<h3>Описание</h3>
	<?php echo Yii::app()->format->ntext($modBug->description) ?>
<?php endif ?>

<h3>История</h3>

<?php foreach ($modBug->messages as $modMessage): ?>
	<div style='margin: 15px 0 15px 30px;'>
		<h5>
			<?php echo $modMessage->user->name . ', ' . Yii::app()->format->datetime($modMessage->time) ?>
			<?php if ($modMessage->id_user == Yii::app()->user->id): ?>
				<small><?php echo CHtml::link('[Удалить]', array('/bugs/message/delete', 'id' => $modMessage->id), array('confirm' => 'Точно?')) ?></small>
				
			<?php endif ?>
		</h5>
		<div><?php echo Yii::app()->format->ntext($modMessage->text) ?></div>
	</div>
<?php endforeach ?>

	<?php $modMessage = new Message ?>
	<?php $modMessage->id_bug = $modBug->id ?>

	<?php $form = $this->beginWidget('DActiveForm', array(
		'id'=>'message-form',
		'stateful' => true,
		'htmlOptions' => array('class' => 'form-horizontal',
								'enctype' => 'multipart/form-data'),
		'action' => array('/bugs/message/create'),
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
	)); ?>


	<div class='well well-small' style='padding-right: 130px; margin-bottom: 0; margin-top: 10px;'>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'label'=>'Написать', 'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -120px; width: 100px;'))); ?> 
		<?php echo $form->textArea($modMessage, 'text', array('class' => 'span12', 'placeholder' => 'Напишите новое сообщение')); ?>
	</div>

	<?php echo $form->hiddenField($modMessage, 'id_bug'); ?>

<?php $this->endWidget(); ?>
