<?php

# ver: 1.0.1.1

//------------------------------------------------------------------------------
class DFileValidator extends CFileValidator
//------------------------------------------------------------------------------
{
	const IMAGE_BAD = 0;
	const IMAGE_OK = 1;
	const IMAGE_TOO_LARGE = 2;

	public $id_folder = 0;

	//----------------------------------------------------------------------------
	protected function validateAttribute($object, $attribute)
	//----------------------------------------------------------------------------
	// Если файл пришел, то подставляем его вместо id
	{

		if ($object->$attribute instanceof CUploadedFile) $objFile = $object->$attribute;
		else {
			$attrFile = $attribute . '_file';
			$attrFileName = CHtml::resolveName($object, $attrFile);		
			$objFile = CUploadedFile::getInstanceByName($attrFileName);			
		}

		if ($objFile != null) 
		{
			$modFile = File::createByFile($objFile, 'directInsert');	// Создаем объект файла по загруженному файлу
			$modFile->id_parent = $this->id_folder;

			$modFile->validate();
			parent::validateAttribute($modFile, 'source');	// Этим валидатором проверить загруженный файл

			// Все ошибки модели файла перенести в проверяемую модель
			foreach ($modFile->errors as $arrErrors)
				foreach ($arrErrors as $strError)
					$object->addError($attribute, $strError);

			if (!$modFile->hasErrors())	$object->$attribute = $modFile;
		}
		else 
		{
			if (!$this->allowEmpty && $object->$attribute == 0)
				return $this->emptyAttribute($object, $attribute);
		}
	}  

	//----------------------------------------------------------------------------
	public function checkImage($strPath, &$arrErrors)
	//----------------------------------------------------------------------------
	{
		$arrErrors = array();
		$intRet = self::IMAGE_OK;

		$maxSize = $this->sizeToBytes(Yii::app()->getModule("files")->maxImageSize);

		if ($this->maxSize !== null)
			$maxSize = min($maxSize, $this->maxSize);

		// Вначале проверить существование
		if (!is_file($strPath))
		{
			$arrErrors[] = 'Файл не найден';
			return self::IMAGE_BAD;
		}

		// Проверить тип
		if (!($t = getimagesize($strPath))) $arrErrors[] = 'Загруженный файл не является изображением';
		elseif (!in_array($t[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_BMP, IMAGETYPE_PNG))) 
			$arrErrors[] = 'Загруженный файл имеет неверный тип. Поддерживаются типы JPG, GIF, PNG, BMP';

		if (count($arrErrors) > 0)
			$intRet = self::IMAGE_BAD;

		// Проверить размер
		if (@filesize($strPath) > $maxSize)
		{
			$arrErrors[] = 'Картинка слишком большая... Она должна быть не больше ' . Yii::app()->format->size(Yii::app()->getModule("files")->maxImageSize);
			$intRet = $intRet == self::IMAGE_OK ? self::IMAGE_TOO_LARGE : $intRet;
		}

		return $intRet;
	}

}
