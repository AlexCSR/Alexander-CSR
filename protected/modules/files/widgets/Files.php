<?php

# ver: 1.0.0
# req: views/files.php

class Files extends CInputWidget
{
	public $uploadUrl;
	public $itemView;

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		$this->uploadUrl = Yii::app()->createUrl('/files/filesWidget/upload');
	}

	//----------------------------------------------------------------------------
	public function run()
	//----------------------------------------------------------------------------
	{
		Yii::app()->controller->setPageState('files-widget-item-view', $this->itemView);

		$this->render('files', array());
	}

	//----------------------------------------------------------------------------
	public function getData()
	//----------------------------------------------------------------------------
	{
		$model = $this->model;
		$attribute = $this->attribute;
		return $model->$attribute;	
	}

}
