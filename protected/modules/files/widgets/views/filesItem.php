<!-- 
	# ver: 1.0.0
-->

<div id='files-widget-item-wrap-<?php echo $modFile->id ?>'>
	<div class='well well-small' style='padding-left: 88px;' >
		<?php Yii::app()->controller->renderPartial($itemView, array('data' => $modFile, 'name' => $name)) ?>		
	</div>

	<?php echo CHtml::link('<i class="icon-remove"></i>', 
							'#', 
							array(
								'style' => 'float: right; margin: -42px 9px 0 0;', 
								'data-id' => $modFile->id,
								'id' => 'files-widget-item-remove-' . $modFile->id,
								'class' => 'files-widget-item-remove')) ?>
</div>



	