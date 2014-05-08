<?php

# ver: 1.0.0
# req: controllers/SiteController.php
# req: controllers/PagesController.php
# req: controllers/FeedbackController.php

class SiteModule extends CWebModule
{
	public function init()
	{

		$objLanguage = new DLanguage;
		$objLanguage->initLanguage();

		// import the module-level models and components
		$this->setImport(array(
			'site.models.*',
			'site.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
