
		<?php echo DImage::image($data, 'min', '', array('style' => 'width: 70px; height: 70px; margin-left: -79px; float: left;')) ?>

		<!-- NAME -->
		<div class="control-group" style='margin-bottom: 0; height: auto;'>
			<label class='control-label' for='files-widget-item-name-<?php echo $data->id ?>'>Наименование</label>
			<div class='controls'>
				<?php echo CHtml::textField($name . '[' . $data->id . ']' . '[name]', $data->name, array('id' => 'files-widget-item-name-' . $data->id, 'class' => 'span8')) ?>			
				<?php echo CHtml::hiddenField($name . '[' . $data->id . ']' . '[id]', $data->id, array('id' => 'files-widget-item-' . $data->id)) ?>
			</div>
		</div>
