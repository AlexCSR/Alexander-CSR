<?php 

	# ver: 1.0.0

?>

<?php 
	$this->widget('bootstrap.widgets.BootGridView', array(
	'type'=>'striped bordered',
	'template' => '{items}{pager}',
	'dataProvider' => new CArrayDataProvider($modBackup->findAll(), array('sort' => false, 'pagination' => false)),
	'selectableRows' => 0,
	'columns' => array(
		'id::ID', 
		'date:datetime:Время создания',
		'name::Имя',
		array('class' => 'bootstrap.widgets.BootButtonColumn', 
				'htmlOptions' => array('style'=>'width: 10px'),
				'visible' => Yii::app()->user->checkAccess('file/admin'),
				'template' => '{retreive}&nbsp;{view}&nbsp;{delete}',
				'viewButtonUrl' => 'array("view", "urlBackup" => $data->id)',         
				'deleteButtonUrl' => 'array("delete", "urlBackup" => $data->id)',

				'buttons' => array(
					'retreive' => array(
						'icon' => 'refresh',
						'url' => 'array("retreive", "urlBackup" => $data->id)',
						'label' => 'Восстановить',
						'click' => 'function() {if (confirm("Точно?")) return true; else return false;}',
						),
				
					),  
						 
				),          
)
	)); 
?>
