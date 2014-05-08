<?php
# ver: 1.0.0.1

/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>

<?php echo "<?php \$form = \$this->beginWidget('DActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'stateful' => true,
	'htmlOptions' => array('class' => 'form-horizontal',
												 'enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
)); ?>\n"; ?>

	<fieldset>

		<div class="control-group">
			<div class='controls'>          
				<?php echo "<?php if(count(\$mod" . $this->modelClass . "->errors) > 0): ?>\n"; ?>
					<?php echo "<div class=\"span10 alert alert-error\">\n"; ?>
					 <?php echo "<?php echo \$form->errorSummary(\$mod" . $this->modelClass . "); ?>\n"; ?>
					<?php echo "</div>\n"; ?>
				<?php echo "<?php endif ?>\n"; ?>
			</div>
		</div>
	<?php foreach($this->tableSchema->columns as $column): ?><?php if($column->autoIncrement) continue; ?>

		<!-- <?php echo strtoupper($column->name) ?> -->
		<div class="control-group <?php echo "<?php if (isset(\$mod" . $this->modelClass . "->errors['" . $column->name . "'])) echo 'error'; ?>"; ?> ">
			<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
			<div class='controls'>
				<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
				<?php echo "<?php echo \$form->error(\$mod" . $this->modelClass . ", '{$column->name}', array('class' => 'help-block')); ?>\n"; ?>
			</div>
		</div>
	<?php endforeach; ?>
	
	</fieldset>

	<div class="form-actions">
		<?php echo "<?php \$this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'link', 'url' => \$this->pageStatePrevious, 'type'=>'danger', 'icon'=>'remove white', 'label'=>'Отмена')); ?>\n"; ?>
		<?php echo "<?php \$this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Готово')); ?>\n"; ?>
	</div>


<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
