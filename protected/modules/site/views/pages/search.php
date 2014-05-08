<?php 

	$objCriteria = new CDbCriteria;

	$objCriteria->compare('title', $modPage->request, true, 'OR');
	$objCriteria->compare('content', $modPage->request, true, 'OR');
	$objCriteria->compare('flg_folder', 0, false, 'AND');


?>

<?php $dp = new CActiveDataProvider($modPage, array('criteria' => $objCriteria)) ?>

<div class="p-news">



	<ul class="w-list">
			<!-- Список статей -->
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider' => $dp,
				'template' => '{items}',
				'ajaxUpdate' => false,
				'itemView' => 'viewFolderItem',
				'emptyText' => '',
				'cssFile' => false, 
			)); ?>
	</ul>

	<!-- Пейджинатор снизу -->
	<div class='pager'>
		<?php $this->widget('CLinkPager', 
						array(
							'pages' => $dp->getPagination(),
							'cssFile' => false,
							'htmlOptions' => array('class' => 'pager'),
							'header' => false,				
							'internalPageCssClass' => 'page',
							'firstPageCssClass' => 'hidden',
							'previousPageCssClass' => 'hidden',
							'nextPageCssClass' => 'hidden',
							'lastPageCssClass' => 'hidden',
							)); ?>
	</div>

</div>


