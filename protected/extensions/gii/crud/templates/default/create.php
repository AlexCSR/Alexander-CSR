<?php
# ver: 1.0.0

/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php echo \$this->renderPartial('_form', array('mod" . $this->modelClass . "'=>\$mod" . $this->modelClass . ")); ?>"; ?>
