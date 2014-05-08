<?php

# ver: 1.1.1

# Внутренние компоненты
# req: components/DActiveRecordFileBehavior.php 1.0
# req: components/DFile.php 1.1
# req: components/DFileValidator.php 1.0
# req: components/DImage.php 1.0
# req: components/DImageBehavior.php 1.0
# req: components/DImageValidator.php 1.0

# req: controllers/AdminController.php
# req: controllers/FilesWidgetController.php

# req: widgets/Files.php

class FilesModule extends CWebModule
{

	// Настройки
	public $assetsPath;
	public $assetsUrl;
	public $uploadPath;	// Куда будут грузиться файлы
	public $downloadRoute;
	public $maxImageSize;
	public $debug = false;

	public $thumbs = array(
		'min' => array('width' => 150, 'height' => 150),
		'mid' => array('width' => 250, 'mode' => 1),
		'big' => array('width' => 600),         
	);


	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		if ($this->assetsUrl === null) 
			$this->assetsUrl = Yii::app()->assetManager->baseUrl . '/files';

		if ($this->assetsPath === null) 
			$this->assetsPath = Yii::app()->assetManager->basePath . '/files';

		if ($this->uploadPath === null) 
			$this->uploadPath = Yii::app()->basePath . '/data/files/';

		if ($this->maxImageSize === null) 
			$this->maxImageSize = '1M'; // 2 MB

		if ($this->downloadRoute === null) 
			$this->downloadRoute = '/files/admin/download';

 
		if (!is_dir($this->assetsPath)) mkdir($this->assetsPath, 0777);

		// import the module-level models and components
		$this->setImport(array(
			'files.models.*',
			'files.components.*',
		));
	}
}
