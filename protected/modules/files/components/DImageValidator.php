<?php

# ver: 1.0.0

//------------------------------------------------------------------------------
class DImageValidator extends DFileValidator
//------------------------------------------------------------------------------
{

	//----------------------------------------------------------------------------
	protected function validateAttribute($object, $attribute)
	//----------------------------------------------------------------------------
	// Если файл пришел, то подставляем его вместо id
	{
		$tmp_attribute = $object->$attribute;

		parent::validateAttribute($object, $attribute);

		if ($object->$attribute instanceof File)
		{
			// Объект прошел валидацию как файл, теперь надо проверить, что он - картинка
			$arrErrors = array();
			$object->$attribute->flg_image = $this->checkImage($object->$attribute->source->tempName, &$arrErrors);
			
			foreach($arrErrors as $strError)
				$object->addError($attribute, $strError);

			if (count($arrErrors) > 0) $object->$attribute = $tmp_attribute;
		}
	}  

}
