<?php


# ver: 1.1.4

# req: /protected/modules/pages/models/Page.php


//******************************************************************************
class DPage extends DActiveRecord
//******************************************************************************

// 1.1.0 - Исключены старые relations и scopes

{

	public $request; // Поисковый запрос
	public $flg_markdown = 0;
	public $id_parent = 0;
	public $flg_public = 1;
	public $template = '[default]';
	private $_breadcrumbs;

	public $arrTemplates = array(		
		'[default]' => 'Автоматически',
		'viewPage' => 'Обычная страница',
		'viewFolder' => 'Список подразделов',
		'viewNews' => 'Список новостей',	
		);

	//----------------------------------------------------------------------------
	public function publishAssets()
	//----------------------------------------------------------------------------
	// Перед показом страницы на сайте мы публикуем все ее ресурсы
	{
		foreach ($this->images as $modFile) 
			if ($modFile->isImage)
				$modFile->publish();
	}

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------	
	{
		$this->tst_create = time();
	}
	
	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'tst_create' => 'Дата',
			'tst_update' => 'Обновлена',
			'flg_public' => 'Публиковать',
			'flg_folder' => 'Это папка',
			'flg_block_header' => 'Блокировать заголовок',
			'flg_block_text' => 'Блокировать текст',
			'flg_markdown' => 'Ручной режим',
			'url' => 'Url',
			'urlFull' => 'Url',
			'template' => 'Шаблон',
			'alias' => 'Псевдоним',
			'keywords' => 'Ключевые слова',
			'description' => 'Описание',
			'content' => 'Текст страницы',
			'images' => 'Картинки',
			'title' => 'Заголовок',
			'areas' => 'Области',
		);
	}

	//----------------------------------------------------------------------------
	public function beforeSave()
	//----------------------------------------------------------------------------
	{
		if (!parent::beforeSave()) return false;

		if ($this->url == '') $this->url = DTranslitFilter::strToUrl($this->getTitle());
		$this->tst_update = time();
		
		return true;
	}

	//----------------------------------------------------------------------------
	protected function beforeDelete()
	//----------------------------------------------------------------------------
	{
		if (!parent::beforeDelete()) return false;

		PageFile::model()->deleteAllByAttributes(array('id_page' => $this->id));

		return true;

	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
			array('title', 'required'),
			array('id_parent, flg_public, flg_folder, tst_create, tst_update, flg_block_header, flg_block_text, flg_markdown', 'length', 'max'=>10),
			array('url, title, alias, template', 'length', 'max'=>255),
			array('url', 'unique', 'criteria' => array('condition' => 'id_parent = ' . $this->id_parent)),
			array('alias', 'unique'),
			array('keywords, description, content, areas, contentAreas', 'safe'),
			array('tst_create', 'DTimestampValidator'),			
		);
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		// ВНИМАНИЕ: уточните имя связи
		return array(
			'images' => array(self::MANY_MANY, 'File', 'tbl_pages_files(id_page, id_file)'),
			'parent' => array(self::BELONGS_TO, 'Page', 'id_parent'),
		);
	}

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		
		return new CArrayDataProvider($this->withImage(array('order' => 'id_sort DESC'))->children, array(
			'pagination' => false,
		));
	}

	//****************************************************************************
	// Области
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function getContentAreas()
	//----------------------------------------------------------------------------
	{
		if(@unserialize($this->content)) return unserialize($this->content);
		else return null;
	}

	//----------------------------------------------------------------------------
	public function setContentAreas($arrAreas)
	//----------------------------------------------------------------------------
	{
		return $this->content = serialize($arrAreas);
	}

	//----------------------------------------------------------------------------
	public function getArea($strArea)
	//----------------------------------------------------------------------------
	{
		if (isset($this->contentAreas[$strArea]))		
			return $this->contentAreas[$strArea];
		else return null;
	}

	//----------------------------------------------------------------------------
	public function getHasAreas()
	//----------------------------------------------------------------------------
	{
		return count($this->defAreas) != 0;
	}

	//----------------------------------------------------------------------------
	public function getDefAreas()
	//----------------------------------------------------------------------------
	{
		if ($this->_defAreas === null)
		{
			$this->_defAreas = array();
			$intMatches = preg_match_all('/(\w+):\s+?(.+?)\s*?$/mui', $this->areas, &$match);
			for ($i=0; $i < $intMatches; $i++) 
				$this->_defAreas[$match[1][$i]] = $match[2][$i];
		}
		return $this->_defAreas;
	}
	private $_defAreas;

	//****************************************************************************
	// ГЕТТЕРЫ
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function getRenderedContent()
	//----------------------------------------------------------------------------
	{
		$this->publishAssets();
		
		if ($this->isMarkdown) {
			$objParser = new CMarkdownParser;
			return $objParser->transform($this->content);
		} else return $this->content;
	}

	//----------------------------------------------------------------------------
	public function getIsMarkdown()
	//----------------------------------------------------------------------------
	{
		return $this->flg_markdown == 1;
	}


	//----------------------------------------------------------------------------
	public function getIsFolder()
	//----------------------------------------------------------------------------
	{
		return $this->flg_folder == 1;
	}

	//----------------------------------------------------------------------------
	public function getIsPublished()
	//----------------------------------------------------------------------------
	{
		if ($this->flg_public == 0) return false;

		/*
		foreach ($this->parents as $modPage)
			if ($modPage->flg_public == 0)
				return false;
		*/

		return true;
	}

	//----------------------------------------------------------------------------
	public function getBreadcrumbs()
	//----------------------------------------------------------------------------
	{
		if ($this->_breadcrumbs == null) {
			$this->_breadcrumbs = array();
			foreach ($this->parents as $modParent) 
				$this->_breadcrumbs[$modParent->getTitle()] = Yii::app()->createUrl('/site/pages/view', array('path' => $modParent->urlFull));
		}
		return $this->_breadcrumbs;
	}

	//----------------------------------------------------------------------------
	public function getUrlFull()
	//----------------------------------------------------------------------------
	// Возвращает полный УРЛ
	{
		$arrRet = '';

		foreach ($this->parents as $modParent)
			$arrRet[] = $modParent->url;
		$arrRet[] = $this->url;

		return implode('/', $arrRet);
	}

	//****************************************************************************
	//	ФАЙНДЕРЫ
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function findByAlias($strAlias)	
	//----------------------------------------------------------------------------
	{
		return $this->findByAttributes(array('alias' => $strAlias));
	}

	//----------------------------------------------------------------------------
	public function findByRoute($strRoute)	
	//----------------------------------------------------------------------------
	{
		$strRoute = trim($strRoute, '/');

		foreach ($this->withImage()->img as $modPage)
			if ($modPage->urlFull == $strRoute)
				return $modPage;

		return null;
	}

	//****************************************************************************
	// 
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function behaviors() 
	//----------------------------------------------------------------------------
	{
		return array(
		  'tree' => array(
			'class' => 'DActiveRecordTreeBehavior',
			'idParent' => 'id_parent',
			),

		  'sort' => array(
			'class' => 'DActiveRecordSortBehavior',
			'idParent' => 'id_parent'
			),

		  'select' => 'DActiveRecordSelectBehavior',		  
		);
	}

	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_pages';}
}