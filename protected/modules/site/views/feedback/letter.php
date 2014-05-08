<h3>Уважаемый администратор!</h3>


<?php if ($modFeedback->isCallback): ?>
	<p>Заказан <strong>обратный звонок</strong></p>
<?php else: ?>
	<p>Принято сообщение обратной связи:</p>
<?php endif ?>

<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$modFeedback,
	'attributes'=>array(
		'tst_create:date',
		'flg_phonecall:boolean',
		'name:text:Отправитель',
		'email',
		'phone',
	),
)); ?>

<p><?php echo CHtml::encode($modFeedback->text) ?></p>

<p>Пожалуйста, не отвечайте на это письмо.</p>
