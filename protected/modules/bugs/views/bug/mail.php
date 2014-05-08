<?php 
	# ver: 1.0.0
?>
<p>Пользователь <?php echo $modBug->user->name ?> сообщил об ошибке: </p>

<?php $this->widget('bootstrap.widgets.BootDetailView', array( 
    'data'=>$modBug, 
    'attributes'=>array( 
        'url:url',
        'enum.id_priority',
        'enum.id_type',
        'description',
    ), 
)); ?> 

<p><?php echo CHtml::link('Открыть страницу ошибки', Yii::app()->createAbsoluteUrl('/bugs/bug/view', array('id' => $modBug->id))) ?></p>