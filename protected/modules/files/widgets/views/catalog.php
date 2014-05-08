<!-- 
	# ver: 1.0.0
-->

<div id='files-select-grid'>
	<ul class='breadcrumbs breadcrumb'>
		<?php if (isset($breadcrumbs)): ?>
			<?php $strHead = array_pop($breadcrumbs) ?>
			<?php foreach ($breadcrumbs as $key => $value): ?>
				<li>
					<?php echo CHtml::link($key, '#', array('class' => 'catalog-node-link', 'onclick' => 'jQuery.ajax({"url": "' . $value . '", "cache":false, "success": function(html){jQuery("#files-select-grid").html(html)}}); return false;'))  ?>
					<span class="divider">/</span>
				</li>
			<?php endforeach ?>
			<li class='active'><?php echo $strHead ?></li>
		<?php else: ?>
			<li class='active'>Файлы</li>
		<?php endif ?>
	</ul>		


	<?php $this->widget('bootstrap.widgets.BootGridView', array(
		'id'=>'file-grid',
		'dataProvider' => $modFile->search(),
		'type'=>'striped bordered hover',
		'template' => '{items}{pager}',
		'ajaxUpdate' => false,
		'selectableRows' => 0,
		'rowCssClassExpression' => '$data->isSelected ? "selected" : ""',
		'htmlOptions' => array('style' => 'margin-top: 0; padding-top: 0;'),
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'FilesCatalog[id_file][]'),
				'disabled' => '$data->isFolder',
				'value' => '$data->id',
			),

			array('header' => 'Имя', 
					'type' => 'raw', 
					'value' => '"<i class=\"icon-" . ($data->isFolder ? "folder-close" : ($data->isImage == 1 ? "picture" : "file")) . "\"></i>&nbsp;&nbsp;"' . 
								' . ($data->isFolder ? CHtml::link($data->name, "#", array("onclick" =>  "jQuery.ajax({\"url\": \"" . Yii::app()->createUrl("/files/filesWidget/catalog", array("id_folder" => $data->id)) . "\", \"cache\":false, \"success\": function(html){jQuery(\"#files-select-grid\").html(html)}}); return false;")) : $data->name)'),
			
			array('name' => 'size', 'type' => 'raw', 'value' => '!$data->isFolder ? ($data->size !== null ? Yii::app()->format->size($data->size) : "<span class=\"badge badge-important\">Не найден</span>") : null', 'htmlOptions' => array('style' => 'width: 80px; text-align: right;')),
			array('name' => 'tst_upload', 'type' => 'date', 'htmlOptions' => array('style' => 'width: 80px;')),
		),
	)); ?>
</div>


