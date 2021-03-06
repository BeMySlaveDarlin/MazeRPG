<?php

namespace Maze\Controllers;

use Maze\Library\Bemyslavedarlin\Helpers\Renderer;
use Maze\Models\Actions;
use Maze\Models\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * Class ControllerBase
 */
class ControllerBase extends Controller
{
    protected $user;
    protected $renderer;

    /**
     * @param Dispatcher $dispatcher
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->renderer = new Renderer();
        $this->getUser();
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        $session_id = $this->session->getId();
        $this->user = Users::findFirstBySessionId($session_id);
        if (false === $this->user) {
            $this->user = new Users();
            $this->user->session_id = $this->session->getId();
            $this->user->level = 1;
            $this->user->points = 1;
            $this->user->room = '00';
            $this->user->save();

            $_action = new Actions();
            $_action->user_id = $this->user->user_id;
            $_action->level = 1;
            $_action->room = '00';
            $_action->status = 'point';
            $_action->save();

            $this->session->set('user_id', $this->user->user_id);

            return $this->response->redirect('/', true)->sendHeaders();
        }
    }

    /**
     * @return array
     */
    protected function getFormattedUserData()
    {
        $actions = [];
        $_actions = Actions::findByUserId($this->user->user_id);
        if (false !== $_actions) {
            foreach ($_actions->toArray() as $action) {
                $actions[$action['level']][$action['room']] = $action;
            }
        }
        $user = $this->user->toArray();
        $user['actions'] = $actions[$user['level']] ?? [];

        return $user;
    }
}
