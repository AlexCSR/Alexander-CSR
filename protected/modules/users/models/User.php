<?php

# ver: 1.0.1

//******************************************************************************
class User extends DUser
//******************************************************************************
{
	public $url_role = 'administrator';



	public static function model($className=__CLASS__) {return parent::model($className);}
}