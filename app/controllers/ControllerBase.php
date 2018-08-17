<?php

use Bemyslavedarlin\Traits\Prototype;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 */
class ControllerBase extends Controller
{
	use Prototype;
	
	/**
	 * @param Dispatcher $dispatcher
	 */
    public function beforeExecuteRoute( Dispatcher $dispatcher )
    {
    	$this->getUser();
    }
}
