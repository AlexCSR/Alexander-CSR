<?php
# ver: 1.0.0

/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>

<?php echo "<?php echo CHtml::beginForm(array('/" . $this->uniqueControllerId . "/index'), 'GET', array('class' => 'form-search', 'style' => '')); ?>\n"?>
  <div class='row-fluid'>
    <div class='span6'><?php echo "<?php echo CHtml::textField('request', \$this->request, array('style' => 'width: 100%;')); ?>"?></div>
    <div class='span2'><?php echo "<?php \$this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'search', 'label'=>'Искать')); ?>"?></div>
  </div>
<?php echo "<?php echo CHtml::endForm(); ?>\n"?>


<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider' => $mod<?php echo $this->modelClass; ?>->search(),
  'template' => '{pager}{items}{pager}',
	'itemView' => 'listItem',
)); ?>
