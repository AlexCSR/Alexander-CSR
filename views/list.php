<?php $this->pageTitle = 'Страницы' ?>

<?php for ($i = 0; $i < 5; $i++): ?>
	<h3><a href='/text'>Новость № <?php echo $i ?></a></h3>
	<p>Текст новости № <?php echo $i ?></p>
<?php endfor ?>

<!-- Виджет для пейджинатора: http://www.yiiframework.com/doc/api/1.1/CLinkPager -->
<?php $this->widget('CLinkPager', 
				array(
					'pages' => new CPagination(100), 	// Не трогать
					'cssFile' => false,					// Не трогать
					'header' => false,					// Не трогать

					'prevPageLabel' => '<',
					'firstPageLabel' => '<<',
					'nextPageLabel' => '>',
					'lastPageLabel' => '>>',

					'htmlOptions' => array('class' => ''),
)); ?>