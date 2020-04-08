<?php

namespace maze\Controllers;

use maze\Library\Bemyslavedarlin\Traits\ControllerAjax;
use maze\Models\Actions;
use maze\Models\Users;
use Phalcon\Http\Response;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Model\ResultSetInterface;
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
     * @return ResultSetInterface|Users|Users[]
     */
    private function getTopPlayers()
    {
        return Users::find(
            [
                'conditions' => "username IS NOT NULL AND username != '' and health_value > 0",
                'order' => 'points DESC',
                'limit' => 10,
            ]
        );
    }

    /**
     * @return Response|ResponseInterface
     */
    public function ajaxAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        //Data processing
        $mode = $this->request->get('mode');
        if (!empty($mode)) {
            return method_exists($this, $mode) ? self::$mode() : $this->noAjaxResult();
        }

        return $this->noAjaxResult();
    }
}

