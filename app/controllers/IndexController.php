<?php

use Phalcon\Mvc\View;

/**
 * Class IndexController
 */
class IndexController extends ControllerBase
{

    public function indexAction()
    {
    
    }
    
    public function ajaxAction()
    {
		$this->view->setRenderLevel( View::LEVEL_MAIN_LAYOUT );
    }

}

