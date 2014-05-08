<?php

# ver: 1.0.0

class DActiveRecordFileBehavior extends CActiveRecordBehavior
{

	//----------------------------------------------------------------------------
	public function beforeSave()
	//----------------------------------------------------------------------------
	{
		foreach ($this->owner->attributes as $key => $modFile) 
		{
			if ($modFile instanceof File)
			{
				$modFile->save();
				$this->owner->$key = $modFile->id;
			}
		}
	}

}

