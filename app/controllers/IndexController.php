<?php

use Bemyslavedarlin\Traits\ControllerAjax;
use Phalcon\Mvc\View;

/**
 * Class IndexController
 */
class IndexController extends ControllerBase
{
	use ControllerAjax;
	
    public function indexAction()
    {
        $viewData['user'] = $this->getFormattedUserData();
        $viewData['top'] = $this->getTopPlayers();
    	$viewData['status'] = $this->renderer->render($viewData['user'], 'status');
    	$viewData['playboard'] = $this->renderer->render($viewData['user'], 'playboard');
    	$this->view->data = $viewData;
    }
	
	/**
	 * @return \Phalcon\Mvc\Model\ResultSetInterface|Users|Users[]
	 */
    private function getTopPlayers()
    {
    	return \Users::find(
		    [
		        "conditions" => "username IS NOT NULL AND username != ''",
		        "order" => "points DESC",
		        "limit" => 10,
		    ]
		);
    }
	
	/**
	 * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
	 */
    public function ajaxAction()
    {
    	$this->view->setRenderLevel( View::LEVEL_NO_RENDER );
    	//Data processing
        $mode = $this->request->get('mode');
        if(!empty($mode))
        {
            return method_exists($this, $mode) ? self::$mode() : $this->noAjaxResult();
        }else{
        	return $this->noAjaxResult();
        }
    }

}

