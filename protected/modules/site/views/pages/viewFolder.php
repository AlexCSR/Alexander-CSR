<?php $dp = new CArrayDataProvider($modPage->children, array('pagination' => array('pageSize' => 25))) ?>
<?php $dp->getData() ?>

<!-- Пейджинатор сверху -->
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



