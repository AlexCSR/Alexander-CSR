<?php

# ver: 1.1.0

class DActiveRecord extends CActiveRecord
{
	public static function model ($className=__CLASS__) {return parent::model($className);}
}

