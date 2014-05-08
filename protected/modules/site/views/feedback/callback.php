<!-- 
	# ver: 1.0.0
-->


				<?php if(count($modFeedback->errors) > 0): ?>

					<div class="" style='font-weight: bold;'>
					 	<?php echo CHtml::errorSummary($modFeedback); ?>
					</div>
				<?php else: ?>
					<p>В ближайшее время с Вами свяжутся наши сотрудники. <a href='/'>Вернуться на главную</a></p>
				<?php endif ?>

