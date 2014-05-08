<!-- 
	# ver: 1.1.p.1

	# Imperavi
	# req: /protected/extensions/imperavi/ImperaviRedactorWidget.php 1.2

-->

<div class="control-group">
	<div class='controls'>          
		<?php if(count($modPage->errors) > 0): ?>
			<div class="span12 alert alert-error">
			 <?php echo $form->errorSummary($modPage); ?>
			</div>
		<?php endif ?>
	</div>
</div>

	

<div class='row-fluid'>

	<div class='span6'>
		<!-- TITLE -->
		<div class="control-group <?php if (isset($modPage->errors['title'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'title', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modPage, 'title', array('class' => 'span12', 'disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'title', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>


	<div class='span6'>
		<!-- URL -->
		<div class="control-group <?php if (isset($modPage->errors['url'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'url', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textField($modPage, 'url', array('class' => 'span12', 'disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'url', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>


</div>


<!-- CONTENT -->

<?php if ($modPage->hasAreas): ?>
	<?php foreach ($modPage->defAreas as $key => $name): ?>

		<div class="control-group <?php if (isset($modPage->errors['content'])) echo 'error'; ?> ">
			<label class="control-label" for="'page-text-area-' . <?php echo $key ?>"><?php echo $name ?></label>		
			<div class='controls'>

					<?php if ($modPage->isMarkdown): ?>

						<?php $this->widget(
							'ext.markitup.JMarkdownEditor',
							array(
								'id' => 'page-text-area-' . $key,

								'model'=>$modPage,
								'attribute'=>'contentAreas[' . $key . ']',

								'theme'=>'simple',
								'htmlOptions'=>array('class' => 'span10', 
														'style' => 'width: 100%; height: ' . (max(100, 400 / count($modPage->defAreas))) . 'px;', 
														'disabled' => $modPage->flg_block_text ? 'disabled' : '' ),
								'options'=>array(
									//'previewParserPath'=>Yii::app()->urlManager->createUrl($preview)
									)
								)); ?>

					<?php else: ?>
						
						Пока не работает


					<?php endif ?>


				<?php echo $form->error($modPage, 'content', array('class' => 'help-block')); ?>
			</div>
		</div>		
	<?php endforeach ?>
<?php else: ?>
	<div class="control-group <?php if (isset($modPage->errors['content'])) echo 'error'; ?> ">
		<?php echo $form->labelEx($modPage, 'content', array('class' => 'control-label')); ?>
		<div class='controls'>


			<?php if ($modPage->isMarkdown): ?>

				<?php $this->widget(
					'ext.markitup.JMarkdownEditor',
					array(
						'id' => 'page-text-area',
						'model'=>$modPage,
						'attribute'=>'content',
						'theme'=>'simple',
						'htmlOptions'=>array('class' => 'span10', 'style' => 'width: 100%; height: 300px;', 'disabled' => $modPage->flg_block_text ? 'disabled' : '' ),
						'options'=>array(
							//'previewParserPath'=>Yii::app()->urlManager->createUrl($preview)
							)
						)); ?>


			<?php else: ?>

				<?php $this->widget('ext.imperavi.ImperaviRedactorWidget', array(
					// You can either use it for model attribute
					'model' => $modPage,
					'attribute' => 'content',

					// Some options, see http://imperavi.com/redactor/docs/
					'options' => array(
						'lang' => 'ru',
						'toolbar' => true,
						'iframe' => true,
						'imageUpload' => Yii::app()->createUrl('/files/filesWidget/uploadImperavi', array('id_page' => $modPage->id)),
						'fileUpload' => Yii::app()->createUrl('/files/filesWidget/uploadFileImperavi', array('id_page' => $modPage->id)),

						// 'css' => 'wym.css',
					),
					'htmlOptions' => array(
						'style' => 'height: 400px;',
						)
				)); ?>
				
			<?php endif ?>

			<?php echo $form->error($modPage, 'content', array('class' => 'help-block')); ?>
		</div>
	</div>
<?php endif ?>


<?php if ($modPage->isMarkdown): ?>

	<!-- Ручная загрузка картинок доступна только в ручном режиме -->
	<div class="control-group <?php if (isset($modPage->errors['images'])) echo 'error'; ?> ">
		<?php echo $form->labelEx($modPage, 'images', array('class' => 'control-label')); ?>
		<div class='controls'>

			<?php $files = $this->widget('application.modules.files.widgets.Files', array(
				'model' => $modPage,
				'attribute' => 'images',
				'itemView' => 'application.modules.pages.views.admin._form_image_item', 
			)) ?>

			<?php echo $form->error($modPage, 'images', array('class' => 'help-block')); ?>
		</div>
	</div>	
<?php endif ?>

<?php if (0): ?>

	<!-- id_image -->
	<div class="control-group <?php if (isset($modPage->errors['id_image'])) echo 'error'; ?> ">
		<?php echo $form->labelEx($modPage, 'id_image', array('class' => 'control-label')); ?>
		<div class='controls'>
			<?php echo $form->uploadImage($modPage, 'id_image', array('class' => 'span12', 'disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
			<?php echo $form->error($modPage, 'id_image', array('class' => 'help-block')); ?>
		</div>
	</div>

	
<?php endif ?>

<div class='row-fluid'>

	<div class='span6'>
		<!-- DESCRIPTION -->
		<div class="control-group <?php if (isset($modPage->errors['description'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'description', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textArea($modPage, 'description', array('class' => 'span12', 'style' => 'height: 100px;', 'disabled' => $modPage->flg_block_text ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'description', array('class' => 'help-block')); ?>
			</div>
		</div>							
	</div>

	<div class='span6'>
		<!-- KEYWORDS -->
		<div class="control-group <?php if (isset($modPage->errors['keywords'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'keywords', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->textArea($modPage, 'keywords', array('class' => 'span12', 'style' => 'height: 100px;', 'disabled' => $modPage->flg_block_text ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'keywords', array('class' => 'help-block')); ?>
			</div>
		</div>					
	</div>
	
</div>

<div class='row-fluid'>




	<div class='span3'>

		<!-- flg_index -->
		<div class="control-group <?php if (isset($modPage->errors['flg_index'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_index', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_index', array('disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'flg_index', array('class' => 'help-block')); ?>
			</div>
		</div>

	</div>

	<div class='span3'>
		<!-- flg_public -->
		<div class="control-group <?php if (isset($modPage->errors['flg_public'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_public', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_public', array('disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'flg_public', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>

	<div class='span3'>

		<!-- flg_menu -->
		<div class="control-group <?php if (isset($modPage->errors['flg_menu'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'flg_menu', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->checkBox($modPage, 'flg_menu', array('disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'flg_menu', array('class' => 'help-block')); ?>
			</div>
		</div>

	</div>

	<div class='span3'>
		<!-- TST_CREATE -->
		<div class="control-group <?php if (isset($modPage->errors['tst_create'])) echo 'error'; ?> ">
			<?php echo $form->labelEx($modPage, 'tst_create', array('class' => 'control-label')); ?>
			<div class='controls'>
				<?php echo $form->dateField($modPage, 'tst_create', 0, array('class' => 'span10', 'disabled' => $modPage->flg_block_header ? 'disabled' : '' )); ?>
				<?php echo $form->error($modPage, 'tst_create', array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>

</div>

