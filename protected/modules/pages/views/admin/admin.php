<!-- 

	# ver: 1.0.p.0.1

-->


<style type="text/css">
	.striped {text-decoration: line-through;}
</style>

<?php echo CHtml::beginForm(array('/pages/admin/select'), 'POST', array('id' => 'page-select-form')) ?>

<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'id'=>'page-grid',
	'dataProvider' => $modPage->search(),
	'type'=>'striped bordered',
	'template' => '{items}{pager}',
	'ajaxUpdate' => false,
	'selectableRows' => 0,	
	'rowCssClassExpression' => '$data->isSelected ? "selected" : ""',
	'columns'=>array(

		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2,
			'checkBoxHtmlOptions' => array('name' => 'id[]'),
			'value' => '$data->id',
		),

		array('name' => 'title', 
				'header' => 'Заголовок',
				'type' => 'raw', 
				'value' => '"<i class=\"icon-" . ($data->isFolder ? "folder-close" : "file") . "\"></i>&nbsp;&nbsp;" . ($data->isFolder ? CHtml::link($data->title, array("/pages/admin/admin", "id_parent" => $data->id)) : $data->title)',
				'cssClassExpression' => '!$data->isPublished ? "striped" : ""'),

		array('header' => 'URL', 'value' => 'Yii::app()->createUrl("site/pages/view", array("path" => $data->urlFull))', 'htmlOptions' => array('style' => 'width: 20%;')),
		array('name' => 'flg_menu', 'header' => 'В меню', 'type' => 'gBoolean', 'htmlOptions' => array('style' => 'width: 50px;')),
		array('name' => 'flg_index', 'header' => 'Витрина', 'type' => 'gBoolean', 'htmlOptions' => array('style' => 'width: 50px;')),
		
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{update}&nbsp;{moveUp}&nbsp;{moveDown}&nbsp;{delete}',
			'headerHtmlOptions' => array('style' => 'width: 80px;'),
			'htmlOptions' => array('style' => 'text-align: right;'),
			'buttons' => array(
				'update',
				'moveUp' => array(
					'icon' => 'arrow-up',
					'url' => 'Yii::app()->createUrl("/pages/admin/moveUp", array("id" => $data->id))',
					'label' => 'Передвинуть вверх',
					),
				'moveDown' => array(
					'icon' => 'arrow-down',
					'url' => 'Yii::app()->createUrl("/pages/admin/moveDown", array("id" => $data->id))',
					'label' => 'Передвинуть вниз',					
					),				
				)

		),
	),
)); ?>


<?php echo CHtml::endForm() ?>
