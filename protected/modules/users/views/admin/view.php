<!-- 
	# ver: 1.0.0
-->

<?php 
	$this->widget('bootstrap.widgets.BootDetailView', array(
	'data' => $modUser,
	'attributes' => array(
		'name',
		'login',
		'email',
		'enum.url_role',
	),
)); ?>
