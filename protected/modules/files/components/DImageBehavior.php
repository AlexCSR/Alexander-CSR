<?php

# ver: 1.0.0.3

//******************************************************************************
class DImageBehavior extends CActiveRecordBehavior
//******************************************************************************
// Цепляется к файлу, делает из него картинку
{

	//****************************************************************************
	// Геттеры
	//****************************************************************************

	public function getAssetsPath()	{return Yii::app()->getModule("files")->assetsPath;}
	public function getAssetsUrl()  {return Yii::app()->getModule("files")->assetsUrl;}
	public function getNoImageAssetPath($strThumb) {return $this->assetsPath . '/' . 'nophoto_' . $strThumb;}
	public function getNoImageAssetUrl($strThumb) {return $this->assetsUrl . '/' . 'nophoto_' . $strThumb;}

	// Разные параметры миниатюр
	public function getThumbSettings() {return Yii::app()->getModule("files")->thumbs;}
	public function thumbPath($strThumb) {return $this->assetsPath . '/' . $this->owner->source . '_' . $strThumb;}
	public function thumbUrl($strThumb) {return $this->assetsUrl . '/' . $this->owner->source . '_' . $strThumb;}

	//****************************************************************************
	// Рисовалки картинок
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function image($strThumb, $alt = '', $htmlOptions = array())
	//----------------------------------------------------------------------------
	// Выводит тэг с картинкой
	{
		$alt = $alt == '' ? $this->owner->name : $alt;
		return CHtml::image($this->publish($strThumb), $alt, $htmlOptions);		
	}

	//----------------------------------------------------------------------------
	public function publish(/* ... */)
	//----------------------------------------------------------------------------
	// Если передан один файл, возвращает строку с адресом, если несколько - массив
	{
		$arrThumbs = func_num_args() == 0 ? array_keys($this->thumbSettings) : func_get_args();

		$arrRet = array();
		foreach ($arrThumbs as $strThumb)
			$arrRet[$strThumb] = $this->createThumb($strThumb);

		return count($arrRet) == 1 ? array_pop($arrRet) : $arrRet;
	}

	//----------------------------------------------------------------------------
	public function publishNoImage($strThumb)
	//----------------------------------------------------------------------------
	// Публикует "нет картинки"
	{
		if (!is_file($this->getNoImageAssetPath($strThumb))) {


			if (is_file(Yii::getPathOfAlias('application.modules.files.assets') . '/nophoto_' . $strThumb))
				copy(Yii::getPathOfAlias('application.modules.files.assets') . '/nophoto_' . $strThumb, $this->getNoImageAssetPath($strThumb));

			else
				DImage::resizeImage(Yii::getPathOfAlias('application.modules.files.assets') . '/nophoto.png', 
									$this->getNoImageAssetPath($strThumb), 
									$this->thumbSettings[$strThumb]['width'],
									isset($this->thumbSettings[$strThumb]['height']) ? $this->thumbSettings[$strThumb]['height'] : 0,
									isset($this->thumbSettings[$strThumb]['mode']) ? $this->thumbSettings[$strThumb]['mode'] : 0);

		}


		return $this->getNoImageAssetUrl($strThumb);
	}

	//----------------------------------------------------------------------------
	public function createThumb($strThumb)
	//----------------------------------------------------------------------------
	// Создает миниатюры
	{
		if (!is_file($this->thumbPath($strThumb)) || Yii::app()->getModule("files")->debug)
		{
			// Создать папку для всех ресурсов
			if (!is_dir($this->assetsPath))	mkdir($this->assetsPath);

			// Создать подпапку
			$pos = stripos($this->owner->source, '/');
			if ($pos !== false) $fld = substr($this->owner->source, 0, $pos);
			if (!is_dir($this->assetsPath . '/' . $fld))
				mkdir($this->assetsPath . '/' . $fld);

			// Создать миниатюру
			if (!is_file($this->owner->sourcePath)) return $this->publishNoImage($strThumb);
			else DImage::resizeImage($this->owner->sourcePath, 
								$this->thumbPath($strThumb), 
								$this->thumbSettings[$strThumb]['width'],
								isset($this->thumbSettings[$strThumb]['height']) ? $this->thumbSettings[$strThumb]['height'] : 0,
								isset($this->thumbSettings[$strThumb]['mode']) ? $this->thumbSettings[$strThumb]['mode'] : 0);
		}

		return $this->thumbUrl($strThumb);
	}

	public static function model($className=__CLASS__) {return parent::model($className);}
}

