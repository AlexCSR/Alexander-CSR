<!-- 
	# ver: 1.0.p.0
	# com: Добавлен функционал обратного звонка
-->

<div class="well" style='padding: 10px; margin-bottom: 10px;'>

	<span style='font-weight: bold;'>
		<?php echo CHtml::encode(Yii::app()->format->datetime($data->tst_create)); ?>, 
		<?php echo CHtml::encode($data->name); ?>,
		<?php if ($data->flg_phonecall == 0): ?>
			<?php echo CHtml::link(CHtml::encode($data->email), 'mailto:' . CHtml::encode($data->email)) ?>
		<?php else: ?>
			<strong style='color: red;'>Заказан звонок на <?php echo CHtml::encode($data->phone) ?></strong>		
		<?php endif ?>
	</span>

	<br />


	<?php echo CHtml::encode($data->text); ?>

</div>