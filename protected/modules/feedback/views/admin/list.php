<!-- 
	# ver: 1.0.0
	# req: /protected/modules/feedback/views/admin/listItem.php
-->

<?php echo CHtml::beginForm(array('/feedback/admin/admin'), 'GET', array('class' => 'form-search', 'style' => '')); ?>
  <div class='row-fluid'>
    <div class='span6'><?php echo CHtml::textField('request', $this->request, array('style' => 'width: 100%;')); ?></div>
    <div class='span2'><?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'search', 'label'=>'Искать')); ?></div>
  </div>
<?php echo CHtml::endForm(); ?>


<?php $this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider' => $modFeedback->search(),
	'template' => '{pager}{items}{pager}',
	'itemView' => 'listItem',
)); ?>
