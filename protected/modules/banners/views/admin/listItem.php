<div>
	<div class='well well-small' style='padding-left: 100px;' >
		<?php echo DImage::image($data->image, 'mic', '', array('style' => 'margin-left: -92px; float: left;')) ?>
		<h4><?php echo $data->name ?></h4>
		<?php echo $data->description ?>
		<br clear='all'>
	</div>


	<div style='float: right; margin: -42px 9px 0 0;'>

		<?php echo CHtml::link('<i class="icon-arrow-up"></i>', 
								array('/banners/admin/moveUp', 'id' => $data->id),
								array(
									)) ?>

		<?php echo CHtml::link('<i class="icon-arrow-down"></i>', 
								array('/banners/admin/moveDown', 'id' => $data->id),
								array(
									)) ?>


		<?php echo CHtml::link('<i class="icon-pencil"></i>', 
								array('/banners/admin/update', 'id' => $data->id),
								array(
									)) ?>


		<?php echo CHtml::link('<i class="icon-remove"></i>', 
								array('/banners/admin/delete', 'id' => $data->id),
								array(
									'confirm' => 'Точно?',
									)) ?>

	</div>

</div>