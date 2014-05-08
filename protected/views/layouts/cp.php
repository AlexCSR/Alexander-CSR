<!DOCTYPE html>
<html lang="en">
	<!-- 
		# ver: 1.0.p.0 
	-->

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<?php Yii::app()->bootstrap->registerCss(); ?>
		<?php Yii::app()->bootstrap->registerYiiCss(); ?>

		<?php Yii::app()->clientScript->registerPackage('jquery'); ?>
		<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.teddevito.assets').'/jquery.textarea.js')); ?>
		
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="/css/cp.css" />

		<title><?php echo CHtml::encode($this->pageTitle . ' | ' . Yii::app()->name) ?></title>
	</head>
	
	<body>
	
		<script type="text/javascript">jQuery(document).ready(function () {$("textarea").tabby();});</script>

		<?php 
		
		$this->widget('bootstrap.widgets.BootNavbar',array(
			'fixed' => false,
			'brand' => Yii::app()->name,
			'brandUrl' => Yii::app()->createUrl('/pages/admin/admin'),
			'items' => array(
				array(
					'class' => 'bootstrap.widgets.BootMenu',		      
					'items'=>array(
						array('label' => 'Техподдержка', 'url' => array('/bugs/bug/admin'), 'visible' => Yii::app()->user->checkAccess('bugs/bug/admin')),								

						array(
							'label' => 'Сервис', 
							'visible' => Yii::app()->user->checkAccess('backuper') || Yii::app()->user->checkAccess('gii'), 
							'items' => array(
								array('label' => 'Пользователи', 'url' => array('/users/admin/admin'), 'visible' => Yii::app()->user->checkAccess('users/admin/admin')),								
								array('label' => 'Резервные копии', 'url' => array('/backuper/backup/admin'), 'visible' => Yii::app()->user->checkAccess('backuper/project/admin')),
								array('label' => 'Генератор кода', 'url' => array('/gii'), 'visible' => Yii::app()->user->checkAccess('assist'), 'linkOptions' => array('target' => '_blanc')),
								)),
						),
					),

				array(
					'class' => 'bootstrap.widgets.BootMenu',		      
					'htmlOptions'=>array('class' => 'pull-right'),
					'items'=>array(
						array('label' => Yii::app()->user->name, 'url'=>array('/users/profile/view'), 'visible' => Yii::app()->user->checkAccess('users/profile')), 
						array('label'=>'Войти', 'url'=>array('/users/login/login'), 'visible' => Yii::app()->user->isGuest),
						array('label'=>'Выйти', 'url'=>array('/users/login/logout'), 'visible' => !Yii::app()->user->isGuest)
						),
					),
				),
		)); ?>


		<div class='container-fluid'>    
			
			<div class='row-fluid'>

				<!-- ЛЕВОЕ МЕНЮ -->
				<div class="span2">
					<?php if (!Yii::app()->user->isGuest): ?>
						<div class='well' style='padding: 10px 0;'>
							<?php 
							$this->widget('bootstrap.widgets.BootMenu', array(
									'type' => 'list',
									'stacked' => 'true',
									'encodeLabel' => false,
									'items' => array(
										array('label' => 'Опции'),
										array('label' => 'Баннеры', 'icon' => 'file', 'url' => array('/banners/admin/admin'), 'visible' => Yii::app()->user->checkAccess('banners/admin/admin')),								
										array('label' => 'Обратная связь', 'icon' => 'envelope', 'url' => array('/feedback/admin/admin'), 'visible' => Yii::app()->user->checkAccess('feedback/admin/admin')),								
										array('label' => 'Настройки', 'icon' => 'cog', 'url' => array('/settings/settings/view'), 'visible' => Yii::app()->user->checkAccess('settings/settings/view')),								
										))); 
							
							?>
						</div>
					<?php endif; ?>
				</div><!-- span2 -->
		
				<!-- ОСНОВНАЯ ОБЛАСТЬ -->  
				<div class="span8">    
					
					<?php if(isset($this->breadcrumbs)):?>
						<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
							'links' => $this->breadcrumbs + array($this->pageTitle),
							'homeLink' =>CHtml::link('Главная', array('/pages/admin/admin')),
						)); ?>
					<?php endif?>
					
					<?php if ($this->showTitle): ?><h1 style='margin-bottom:10px;'><?php echo $this->pageTitle; ?></h1><?php endif ?>

					<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
					
					<?php echo $content; ?>

				</div>
				
				<!-- ПРАВОЕ МЕНЮ -->
				<div class="span2">
					<?php if (!$this->isMenuNull): ?>
						<div class='well' style='padding: 10px 0;'>
							<?php   	
								$this->widget('bootstrap.widgets.BootMenu', array(
									'type' => 'list',
									'stacked' => true,
									'items' => $this->menu,
								));        		
							?>
						</div>
					<?php endif; ?>
				</div><!-- span2 -->
			
			</div><!-- row -->
			
			
			<hr clear='all'>
			<div class='row-fluid'>
				<div class='span2'>&nbsp;</div>
				<div class='span8 offset2' style='text-align: center;'>  
					<footer>
						<p><?php echo CHtml::link('Сообщить об ошибке', array('/bugs/bug/create', 'url' => Yii::app()->controller->createAbsoluteUrl(Yii::app()->request->requestUri)), array('target' => '_blank')) ?> © <a href="http://dubus.ru">Dubus Group</a>, <?php echo date('Y') ?>.</p>
					</footer>
				</div>
			</div><!-- row -->  
		</div>
		
	</body>
</html>
