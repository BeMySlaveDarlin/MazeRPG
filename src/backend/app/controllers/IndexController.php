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
        $gameData['user'] = $this->getFormattedUserData();
        $gameData['players'] = $this->getTopPlayers()->toArray();
        $gameData['statuses'] = $this->renderer->render($gameData['user'], 'status');
        $gameData['playboard'] = $this->renderer->render($gameData['user'], 'playboard');
        
        $this->calcUserPoints();
        
        $this->view->game = (object)$gameData;
    }
    
    /**
     * @return \Phalcon\Mvc\Model\ResultSetInterface|Users|Users[]
     */
    private function getTopPlayers()
    {
        return Users::find(
            [
                "conditions" => "username IS NOT NULL AND username != ''",
                "order"      => "points DESC",
                "limit"      => 10,
            ]
        );
    }
    
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function ajaxAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        //Data processing
        $mode = $this->request->get('mode');
        if (!empty($mode)) {
            return method_exists($this, $mode) ? self::$mode() : $this->noAjaxResult();
        } else {
            return $this->noAjaxResult();
        }
    }
}

