
<h3>В шапке сайта (слайдер) <small><?php echo CHtml::link('Добавить', array('/banners/admin/create', 'id_position' => Banner::POSITION_TOP)) ?></small></h3>

<div class='grid-view'>
	<?php $arrPosBanners = $modBanner->top()->findAll() ?>
	<?php $this->widget('bootstrap.widgets.BootListView', array(
		'dataProvider' => new CArrayDataProvider($arrPosBanners, array('pagination' => false)),
		'template' => '{pager}{items}{pager}',
		'itemView' => 'listItem',
	)); ?>
</div>

	
<h3>В правой колонке <small><?php echo CHtml::link('Добавить', array('/banners/admin/create', 'id_position' => Banner::POSITION_RIGHT)) ?></small></h3>

<div class='grid-view'>
	<?php $arrPosBanners = $modBanner->right()->findAll() ?>
	<?php $this->widget('bootstrap.widgets.BootListView', array(
		'dataProvider' => new CArrayDataProvider($arrPosBanners, array('pagination' => false)),
		'template' => '{pager}{items}{pager}',
		'itemView' => 'listItem',
	)); ?>
</div>