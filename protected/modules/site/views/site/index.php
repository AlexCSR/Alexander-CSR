<?php $modPage = Page::model()->findByAlias('index') ?>

<div class="w-news">


	<?php $arrNews = $modPage->withImage(array('order' => 'id_sort DESC'))->children ?>
	
	<?php foreach ($arrNews as $modNews): ?>


		<div class="item">
			<u></u><s></s>
			<div class="title"><b><?php echo CHtml::link($modNews->getTitle(), array('/site/pages/view', 'path' => $modNews->urlFull)) ?></b></div>
			<div class="text"><?php echo $modNews->getDescription() ?></div>
			<div class="more"><?php echo CHtml::link('Подробнее', array('/site/pages/view', 'path' => $modNews->urlFull)) ?></div>
		</div>


	<?php endforeach ?>



</div>



<h1><?php echo $modPage->getTitle() ?></h1>
<div class="w-text"><?php echo $modPage->getContent() ?></div>