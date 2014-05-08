<?php

# ver: 1.1.0.1

class DActiveForm extends CActiveForm
{

	//----------------------------------------------------------------------------
	public function dateField($model, $attribute, $data, $htmlOptions = array())
	//----------------------------------------------------------------------------
	{
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
									//'model' => $model,
									//'attribute' => $attribute,
									'name' => CHtml::resolveName($model, $attribute),
									'value' => ($model->$attribute != null && $model->$attribute != '' && $model->$attribute != 0 ? date('d.m.Y', $model->$attribute) : ''),
									'options' => array(
										'dateFormat' => 'dd.mm.yy'
										),
									'htmlOptions' => $htmlOptions));
	}

	//----------------------------------------------------------------------------
	public function uploadImage($model, $attribute, $htmlOptions=array())
	//----------------------------------------------------------------------------  
	// Картинка
	{
		$attr_name = CHtml::resolveName($model, $attribute);
		$file_name = substr($attr_name, 0, -1) . '_file]';
		
		// Отобразить загруженную картинку
		$modImage = File::model()->findByPk($model->$attribute);
		if ($modImage === null || !$modImage->isImage) $strImage = '';
		else $strImage = $modImage->image('mic', '', array('style' => 'margin-right: 10px;'));

		return '<div class="well span12" style="padding: 10px; margin-bottom: 0;">' . $strImage . CHtml::fileField($file_name) . '</div><div style="clear:both;"></div>';
	}  

	//----------------------------------------------------------------------------
	public function uploadFile($model, $attribute, $htmlOptions=array())
	//----------------------------------------------------------------------------  
	// Картинка
	{
		$attr_name = CHtml::resolveName($model, $attribute);
		$file_name = substr($attr_name, 0, -1) . '_file]';
		
		// Отобразить загруженную картинку
		$modFile = DFile::model()->findByPk($model->$attribute);
		if ($modFile === null) $strFile = 'Файл не загружен';
		else $strFile = $modFile->downloadLink();


		return ($strFile . '<br>' . 
		 		CHtml::hiddenField($attr_name, $model->$attribute) . 
				 CHtml::fileField($file_name));
	}   
}