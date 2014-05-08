<!-- 
	# ver: 1.0.0.1
	# req: filesItem.php
	# req: catalog.php
-->

<div id='files-widget-wrap'>
	<?php foreach ($this->data as $k => $modFile): ?>
		<?php $this->render('filesItem', array(
											'name' => CHtml::activeName($this->model, $this->attribute),
											'modFile' => $modFile,
											'itemView' => $this->itemView,
											)) ?>
	<?php endforeach ?>
</div>

<div class='row-fluid'>
	<div class='well well-small span12' style='padding-right: 209px;'>
		<?php echo CHtml::fileField('FilesCatalog[file]', '', array('id' => 'page-image-upload')) ?>

		<?php Yii::app()->controller->widget('bootstrap.widgets.BootButton', array(
			'buttonType' => 'link',
			'label' => 'Выбрать',
			'type'=>'primary',
			'url' => '#',
			'htmlOptions' => array('data-toggle' => 'modal', 'data-target' => '#files-widget-catalog-modal', 'style' => 'width: 85px; float: right; margin-right: -200px;'),
		)); ?>

		<?php Yii::app()->controller->widget('bootstrap.widgets.BootButton', array(
			'buttonType' => 'link',
			'label' => 'Загрузить',
			'type'=>'primary',
			'htmlOptions' => array('onClick' => "ajaxFileUpload();", 'data-dismiss'=>'modal', 'style' => 'width: 85px; margin-right: -85px; margin-left: 0; float: right;')
		)); ?>
	</div>
</div>

<!-- МОДАЛ ВЫБОР ИЗ КАТАЛОГА -->
<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id' => 'files-widget-catalog-modal')); ?>
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h4>Выберите файлы</h4>
		</div>
		 
		<div class="modal-body">
			<?php $modFile = new File ?>
			<?php $modFile->dbCriteria = new CDbCriteria(array('condition' => '`id_parent` = 0', 'order' => 'flg_folder DESC, name')); ?>
			<?php $this->render('catalog', array('modFile' => $modFile)) ?>
		</div>
		 
		<div class="modal-footer">

			<?php echo CHtml::hiddenField('FilesCatalog[attributeName]', CHtml::activeName($this->model, $this->attribute)) ?>

			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'type'=>'primary',
				// 'buttonType' => 'ajaxSubmit',
				'url' => array('/files/filesWidget/catalogAdd'),
				'label'=>'Добавить',
				'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => 'files-widget-modal-submit'),
				'ajaxOptions' => array('success' => 'function(html){jQuery("#files-widget-wrap").append(html)}'),
			)); ?>

			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'label'=>'Отменить',
				'url'=>'#',
				'htmlOptions'=>array('data-dismiss'=>'modal'),
			)); ?>
		</div>
<?php $this->endWidget(); ?>

<!-- ИНСТРУМЕНТЫ ДЛЯ ЗАГРУЗКИ -->
<?php Yii::app()->getClientScript()->registerScriptFile( CHtml::asset(Yii::getPathOfAlias('ext.ajaxfileupload.ajaxfileupload') . '.js') ); ?>

<script type="text/javascript">

	jQuery(function(){



		jQuery('body').on('click','#files-widget-modal-submit',function(){ 
			jQuery.ajax({
				'success': function(html){jQuery("#files-widget-wrap").append(html)},
				'type': 'POST',
				'url': '<?php echo Yii::app()->createUrl("/files/filesWidget/catalogAdd", array()) ?>',
				'cache':false,
				'data':jQuery(this).parents("form").serialize()});

			return false;
		});


		jQuery('body').on('click', '.files-widget-item-remove',function() {
			
			if (!confirm("Точно?")) return false;

			jQuery("#files-widget-item-wrap-" + jQuery(this).attr('data-id')).remove();

			return false;
		});

		// Загрузка картинки на сервер
		ajaxFileUpload = function()
		{
			jQuery.ajaxFileUpload
			(
				{
					url: "<?php echo $this->uploadUrl ?>", 
					secureuri: false,
					fileElementId: 'page-image-upload',
					dataType: 'json',

					success: function (data, status)
					{
						// Обновить грид или выдать ошибку
						if(data.error != '') {
							alert(data.error);
							return false;
						}
						
						jQuery.ajax(
						{
							'url': "<?php echo Yii::app()->createUrl('/files/filesWidget/view', array('name' => CHtml::activeName($this->model, $this->attribute), 'itemView' => $this->itemView)) ?>&id=" + data.id,
							'type':'GET',
							'cache':false,
							'dataType': "html",
							'success': function(html){jQuery("#files-widget-wrap").append(html)},
						});
					},

					handleError: function (data, status, e)
					{
						alert(e);
					}
				}
			)
			
			return false;
		} 


	});
				
</script>




