<!DOCTYPE html>
<html>
	<head>
		<title>Заголовок страницы</title>
	</head>

	<body>

		<!-- Меню, описание виджета: http://www.yiiframework.com/doc/api/1.1/CMenu -->
		<?php $this->widget('zii.widgets.CMenu', array(
			'items'=>array(
				array('label' => 'Текстовая страница', 'url'=>'/text'),
				array('label' => 'Список', 'url'=>'/list', 'active' => true),
				array('label' => 'Форма', 'url'=>'/form', 'active' => true),
				array('label' => 'Подразделы', 'items' => array(
					array('label' => 'Подраздел 1', 'url' => '#'),
					array('label' => 'Подраздел 2', 'url' => '#'),       	
				)),
			),
		)); ?>

		<!-- Хлебные крошки, описание виджета: http://www.yiiframework.com/doc/api/1.1/CBreadcrumbs -->
		<?php if($this->showBreadcrumbs):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs + array($this->pageTitle), 'separator' => ' / ')); ?>
		<?php endif ?>

		<!-- Заголовок страницы -->
		<?php if ($this->showTitle): ?>
			<h1><?php echo $this->pageTitle; ?></h1>
		<?php endif; ?>	

		<!-- Содержимое. 
			Будет показан файл, указанный в адресе.

			При необходимости определите в подключаемом файле: 
			- флаги $this->showTitle и $this->showBreadcrumbs для отключения отображения ХК и заголовка
			- $this->pageTitle - заголовок
			- $this->breadcrumbs - ХК, формат: array('Имя страницы' => 'URL') -->
		<div id="content"><?php echo $content; ?></div>					
	</body>
</html>

