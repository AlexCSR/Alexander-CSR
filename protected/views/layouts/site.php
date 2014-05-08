<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="ImageResize" content="no" />
		<meta http-equiv="ImageToolbar" content="no" />
		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<!--[if (gte IE 6)&(lte IE 8)]>
		  <script type="text/javascript" src="/js/selectivizr.js"></script>
		<![endif]--> 
		<?php $modSettings = new Settings ?>
		<title><?php echo (Yii::app()->controller->route == 'site/site/index' ? '' : $this->browserTitle . ' | ') . Yii::app()->settings->browserTitle ?></title>
	</head>
	<body>
		<div class="wrap">
			<div id="page">
				<div class="header">
					<div class="header-logo"><a href=""></a></div>
					<div class="header-user">
						<?php if (Yii::app()->user->isGuest): ?>
							
							<?php echo CHtml::beginForm(array('/site/site/login'), 'POST', array('class' => 'header-notlogged')) ?>
								<?php $modLogin = new UserLogin ?>
								<div class="input login placeholder"><?php echo CHtml::activeTextField($modLogin, 'login') ?><span>логин</span></div>
								<div class="input password placeholder"><?php echo CHtml::activePasswordField($modLogin, 'password') ?><span>пароль</span></div>
								<div class="button"><input type="submit" value=""><i></i></div>
							<?php echo CHtml::endForm() ?>

						<?php else: ?>

							<?php echo CHtml::beginForm(array('/site/site/logout'), 'POST', array('class' => 'header-logged')) ?>
								<div class="name"><span><?php echo Yii::app()->user->name ?></span></div>
								<div class="button"><input type="submit" value=""><i></i></div>							
							<?php echo CHtml::endForm() ?>
						</form>

						<?php endif ?>


					</div>
					<div class="header-rightside">
						<ul class="header-lang">
							<li class="<?php echo Yii::app()->language == 'ru' ? 'active' : '' ?>"><?php echo CHtml::link('<i class="ru"></i><span>RU</span>', array('/site/site/setLanguage', 'language' => 'ru')) ?></li>
							<li class="<?php echo Yii::app()->language == 'en' ? 'active' : '' ?>"><?php echo CHtml::link('<i class="en"></i><span>EN</span>', array('/site/site/setLanguage', 'language' => 'en')) ?></li>
						</ul>
						<div class="header-contacts">
							<p><?php echo Yii::app()->settings->phone1 ?></p>
							<p><?php echo Yii::app()->settings->phone2 ?></p>
							<a href="mailto:<?php echo Yii::app()->settings->email ?>"><?php echo Yii::app()->settings->email ?></a>
						</div>
					</div>
				</div>

				<div class="navline">
					<?php $arrItems = array(
						array(
							'label' => 'Главная',
							'url' => array('/site/site/index'),
							)) ?>
					<?php $arrItems += Page::model()->getMenuItems() ?>
					<?php $this->widget('zii.widgets.CMenu', array(
										'htmlOptions' => array('class' => ''),
										'items' => $arrItems,
										)); ?>


					<?php $modPage = isset(Yii::app()->controller->searchPage) ? Yii::app()->controller->searchPage : new Page('search') ?>
					<?php echo CHtml::beginForm(array('/site/pages/search'), 'GET') ?>
						<div class="input placeholder"><?php echo CHtml::activeTextField($modPage, 'request') ?><span>Поиск по сайту</span></div>
						<div class="button"><input type="submit" value=""></div>
					<?php echo CHtml::endForm() ?>
				</div>
				<div class="main">
					<div class="leftcol">

						<?php if(isset($this->breadcrumbs) && $this->breadcrumbs !== null):?>
							<?php $this->widget('zii.widgets.CBreadcrumbs', 
												array('links' => $this->breadcrumbs + array($this->breadcrumbsEnding),
														'separator' => ' / ')); ?>
						<?php endif ?>

						<?php if ($this->showTitle): ?><h1><?php echo $this->pageTitle; ?></h1><?php endif; ?>	

						<div id="content"><?php echo $content; ?></div>
					</div>
					<div class="rightcol">
						<?php if (!Yii::app()->user->isGuest): ?>							
							<dl class="block-advanced">

								<?php $objAdd = Page::model()->findByAlias('additional') ?>
								<?php $arrAdd = $objAdd->withImage(array('order' => 'id_sort DESC'))->children ?>
								
								<dt><?php echo $objAdd->getTitle() ?></dt>
								<?php foreach ($arrAdd as $modAdd): ?>
									<dd class="<?php echo (isset(Yii::app()->controller->idCurrent) && Yii::app()->controller->idCurrent == $modAdd->id) ? 'active' : '' ?>"><?php echo CHtml::link($modAdd->getTitle(), array('/site/pages/view', 'path' => $modAdd->urlFull)) ?></dd>
								<?php endforeach ?>
							</dl>
						<?php endif ?>


						<div class="block-ask"><?php echo CHtml::link(Yii::t('site', 'Задать вопрос'), array('/site/feedback/form')) ?></div>
						<div class="block-news">
							<div class="block-news-title">Новости</div>




							<ul>

								<?php $objNews = Page::model()->findByAlias('news') ?>
								<?php $arrNews = $objNews->withImage(array('order' => 'id_sort DESC'))->children ?>
								
								

								<?php for ($i = 0; $i < 4; $i++): ?>
									<?php if (!isset($arrNews[$i])) break; else $modNews = $arrNews[$i]; ?>
									<li>
										<?php echo CHtml::link('<b>' . Yii::app()->format->date($modNews->tst_create) . '</b> ' . $modNews->getTitle(), array('/site/pages/view', 'path' => $modNews->urlFull)) ?>
										<p><?php echo $modNews->getDescription() ?></p>
									</li>
								<?php endfor; ?>

							</ul>
						</div>
						<?php if (0): ?>							
							<ul class="block-banners">
								<li><a href=""><img src="/images/temp/banner-202x170.jpg" alt=""></a></li>
								<li><a href=""><img src="/images/temp/banner-202x98.jpg" alt=""></a></li>
							</ul>
						<?php endif ?>

					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="footer-left">Все права защищены <br>Национальный удостоверяющий центр 2014</div>
			<div class="footer-right"><?php echo Yii::app()->settings->phone1 ?>, <?php echo Yii::app()->settings->phone2 ?> <br><a href="mailto:<?php echo Yii::app()->settings->email ?>"><?php echo Yii::app()->settings->email ?></div>
		</div>
		<script type="text/javascript" src="/js/lib.js"></script>
	</body>
</html>
<!-- www.verstka.pro -->

