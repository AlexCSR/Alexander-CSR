<?php

# ver: 1.1.p.0

//******************************************************************************
class Page extends DPage
//******************************************************************************
{

	public $flg_show_news = 1;
	public $flg_show_slider = 1;

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------
	{
		return array_merge(parent::attributeLabels(), array(
				'id_image' => 'Главная картинка',
				'flg_menu' => 'В меню',
				'flg_index' => 'На главной',
				'flg_show_news' => 'Новости',
				'flg_show_slider' => 'Слайдер',
				'title_en' => 'Title',
				'content_en' => 'Content',
				'description_en' => 'Description',

			));

	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------
	{
		return array_merge(parent::rules(), array(
				array('id, id_sort', 'safe', 'on' => 'import'),
				array('title_en', 'length', 'max' => 255),
				array('content_en, description_en', 'safe'),
				array('id_image', 'DImageValidator', 'allowEmpty' => true),
				array('flg_menu, flg_index, flg_show_news, flg_show_slider', 'length', 'max' => 10),
				array('request', 'safe', 'on' => 'search'),
			));
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		return array_merge(parent::relations(), array(
			'image' => array(self::BELONGS_TO, 'File', 'id_image'),

			));

	}

	//----------------------------------------------------------------------------
	public function scopes()
	//----------------------------------------------------------------------------
	{
		return array_merge(parent::scopes(), array(

		));

	}

	//----------------------------------------------------------------------------
	public function behaviors()
	//----------------------------------------------------------------------------
	{
		return array_merge(parent::behaviors(), array(
				'file' => 'DActiveRecordFileBehavior',
			));

	}

	//----------------------------------------------------------------------------
	public function getIsInMenu()
	//----------------------------------------------------------------------------
	{
		return $this->isPublished && $this->flg_menu == 1;
	}

	//----------------------------------------------------------------------------
	public function getIsInIndex()
	//----------------------------------------------------------------------------
	{
		return $this->isPublished && $this->flg_index == 1;
	}

	//----------------------------------------------------------------------------
	public function getShowNews()
	//----------------------------------------------------------------------------
	{
		return $this->flg_show_news == 1;
	}

	//----------------------------------------------------------------------------
	public function getShowSlider()
	//----------------------------------------------------------------------------
	{
		return $this->flg_show_slider == 1;
	}

	//----------------------------------------------------------------------------
	public function getMenuItems()
	//----------------------------------------------------------------------------
	{
		$arrItems = array();  
		$modPage = new Page;
		foreach($modPage->withImage(array('order' => 'id_sort DESC'))->img as $modPage) {
			if ($modPage->isInMenu && $modPage->id_parent == 0) {
				$arrItemItems = array();
				foreach ($modPage->children as $modPagePage) {
					if ($modPagePage->isInMenu) {
						$arrItemItems[] = array(
							'label' => $modPagePage->getTitle(),
							'url' => array('/site/pages/view', 'path' => $modPagePage->urlFull),
							);
					}
				}

				$arrItems[] = array(
					'label' => $modPage->getTitle(),
					'url' => array('/site/pages/view', 'path' => $modPage->urlFull),
					'items' => $arrItemItems,
					'linkOptions' => count($arrItemItems) > 0 ? array('onclick' => 'return false;', 'style' => 'cursor: default;') : array(),
					);
			}

		}
		
		return $arrItems;	
	}

	//----------------------------------------------------------------------------
	public function getTitle()
	//----------------------------------------------------------------------------
	{
		if (Yii::app()->language == 'en' && $this->title_en != '') return $this->title_en;
		else return $this->title;
	}

	//----------------------------------------------------------------------------
	public function getContent()
	//----------------------------------------------------------------------------
	{
		if (Yii::app()->language == 'en' && $this->content_en != '') return $this->content_en;
		else return $this->content;
	}

	//----------------------------------------------------------------------------
	public function getDescription()
	//----------------------------------------------------------------------------
	{
		if (Yii::app()->language == 'en' && $this->description_en != '') return $this->description_en;
		else return $this->description;
	}
	public static function model($className=__CLASS__) {return parent::model($className);}
}