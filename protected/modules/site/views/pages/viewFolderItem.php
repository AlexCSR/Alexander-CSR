<?php if (!isset($showDate)) $showDate = false ?>
	
<div class="item">
	<div class="title">
		<?php if ($showDate): ?><?php echo CHtml::encode(Yii::app()->format->date($data->tst_create)) ?><?php endif ?>
		<?php echo CHtml::link(CHtml::encode($data->getTitle()), array('/site/pages/view', 'path' => $data->urlFull), array('style' => $showDate ? '' : 'margin-left: 0;')) ?></div>
	<p><?php echo CHtml::encode($data->getDescription()) ?></p>
</div>