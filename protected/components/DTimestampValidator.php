<?php

# ver: 1.0.0

class DTimestampValidator extends CValidator
{

	public function validateAttribute($object, $attribute)
	{
		if (!is_numeric($object->$attribute))
			$object->$attribute = strtotime($object->$attribute);

		return true;
	}
}

