<!-- 
	# ver: 1.1.0
-->

<?php $form=$this->beginWidget('CActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'htmlOptions' => array('style' => 'margin-bottom: 0;'),
)); ?>
	<div class='well well-small' style='padding-right: 130px; margin-bottom: 0;'>
		<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'icon-search icon-white', 'label'=>'Искать', 'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -120px; width: 100px;'))); ?> 
		<?php echo $form->textField($modFile, 'request', array('style' => 'margin-bottom: 0; width: 100%;')); ?> 
	</div>
<?php $this->endWidget(); ?>


<?php echo CHtml::beginForm(array('/files/admin/select'), 'POST', array('id' => 'files-select-form')) ?>


	<?php $this->widget('bootstrap.widgets.BootGridView', array(
		'id'=>'file-grid',
		'dataProvider'=>$modFile->search(),
		'type'=>'striped bordered hover',
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
			array('header' => 'Имя', 'type' => 'raw', 'value' => '"<i class=\"icon-" . ($data->isFolder ? "folder-close" : ($data->isImage == 1 ? "picture" : "file")) . "\"></i>&nbsp;&nbsp;" . ($data->isFolder ? CHtml::link($data->name, array("/files/admin/admin", "id_parent" => $data->id)) : $data->name)'),
			array('name' => 'size', 'type' => 'raw', 'value' => '!$data->isFolder ? ($data->size !== null ? Yii::app()->format->size($data->size) : "<span class=\"badge badge-important\">Не найден</span>") : null', 'htmlOptions' => array('style' => 'width: 80px; text-align: right;')),
			array('name' => 'tst_upload', 'type' => 'date', 'htmlOptions' => array('style' => 'width: 80px;')),
			array(
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template' => '{download}&nbsp;{update}&nbsp{delete}',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'buttons' => array(
					'download' => array(
						'icon' => 'download-alt',
						'label' => 'Загрузить',
						'url' => 'array("/files/admin/download", "id" => $data->id)',
						'visible' => '!$data->isFolder'),					
					'update' => array(
						'visible' => 'Yii::app()->user->checkAccess("files/admin/update")'),
					'delete' => array(
						'visible' => 'Yii::app()->user->checkAccess("files/admin/delete")'),

					)

			),
		),
	)); ?>

<?php echo CHtml::endForm() ?>

<?php if (Yii::app()->user->checkAccess("files/admin/uploadFiles")): ?>

<hr>
	

	<?php echo CHtml::beginForm(array('/files/admin/uploadFiles', 'id_parent' => $modFile->id_parent), 'POST', array('enctype' => 'multipart/form-data')) ?>

		<div style='padding-right: 180px;'>


	    <?php $this->widget('bootstrap.widgets.BootButton', 
	                        array('buttonType'=>'submit', 
	                              'type'=>'primary', 
	                              'icon'=>'ok white', 
	                              'label'=>'Загрузить',
	                              'htmlOptions' => array('style' => 'float: right; text-align: left; margin-right: -180px; width: 150px;'))); ?>

	  	<?php
	  		$this->widget('CMultiFileUpload', array(
	  		 	'name' => 'source',
	  		));
	  	?>
		</div>
	<?php echo CHtml::endForm() ?>

<?php endif ?>