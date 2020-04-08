<?php

namespace maze\controllers;

use maze\library\bemyslavedarlin\helpers\Renderer;
use maze\models\Actions;
use maze\models\Users;
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
        $this->user = Users::findFirst(['conditions' => "session_id = '" . $session_id . "'"]);
        if (!$this->user) {
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
        if (!empty($_actions = Actions::find(['conditions' => 'user_id = ' . $this->user->user_id]))) {
            foreach ($_actions->toArray() as $action) {
                $actions[$action['level']][$action['room']] = $action;
            }
        }
        $user = $this->user->toArray();
        $user['actions'] = $actions[$user['level']] ?? [];

        return $user;
    }
}
