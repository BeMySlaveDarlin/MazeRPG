<?php

namespace Bemyslavedarlin\Traits;

use Actions;
use Users;

/**
 * Trait ControllerAjax
 *
 * @package Bemyslavedarlin\Traits
 */
trait ControllerAjax
{
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    private function noAjaxResult()
    {
        $response = [
            'status'  => 'error',
            'message' => 'Empty ajax result',
        ];
        $this->response->setJsonContent($response);
        
        return $this->response;
    }
    
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    private function setUsername()
    {
        $username = $this->request->get('username');
        if (!empty($username)) {
            $user = Users::findFirst(['username' => $username])->toArray();
            if (empty($user['user_id'])) {
                $response = [
                    'status'  => 'error',
                    'message' => 'Username already in use',
                ];
            } else {
                $this->user->username = $username;
                if ($this->user->save()) {
                    $userData = $this->getFormattedUserData();
                    $html = $this->renderer->render($userData, 'rooms');
                    $response = [
                        'status'  => 'success',
                        'message' => 'Username successfully set',
                        'board'   => $html,
                        'user'    => $this->user,
                    ];
                } else {
                    $response = [
                        'status'  => 'error',
                        'message' => 'Cannot save Username',
                    ];
                }
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Empty username',
            ];
        }
        
        $this->response->setJsonContent($response);
        
        return $this->response;
    }
    
    /**
     * @return mixed
     */
    private function setAction()
    {
        $actions = [
            'boss',
            'monster',
            'item',
            'point',
        ];
        $directions = [
            'left',
            'right',
            'top',
            'bottom',
        ];
        
        $action = $this->request->get('action');
        $direction = $this->request->get('direction');
        
        if (
            in_array($direction, $directions)
            && in_array($action, $actions)
            && $this->user->health_value > 0
        ) {
            $room = $this->calcRoom($direction);
            $_action = new Actions();
            $_action->user_id = $this->user->user_id;
            $_action->level = $this->user->level;
            $_action->room = $room;
            $_action->status = $action;
            
            if ($_action->save()) {
                $this->calcStats($action, $room);
                $userData = $this->getFormattedUserData();
                $html = $this->renderer->render($userData, 'rooms');
                
                $response = [
                    'status'  => 'success',
                    'message' => 'Action successfully done',
                    'board'   => $html,
                    'user'    => $this->user,
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => "Can't do action",
                ];
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Wrong action or direction',
            ];
        }
        
        $this->response->setJsonContent($response);
        
        return $this->response;
    }
    
    /**
     * @param $direction
     *
     * @return string
     */
    private function calcRoom($direction)
    {
        $room = $this->user->room;
        $room = $direction == 'left' ? $room - 1 :
            (
            $direction == 'right' ? $room + 1 :
                (
                $direction == 'top' ? $room - 10 : $room + 10
                )
            );
        $room = sprintf("%02d", $room);
        
        return $room;
    }
    
    /**
     * @param $action
     *
     * @return string
     */
    private function calcStats($action, $room)
    {
        $method = 'calc' . ucfirst($action);
        if (method_exists($this, $method)) {
            self::$method();
        }
        
        if ($room == '79') {
            $this->user->level += 1;
            $this->user->room = '00';
            $this->createZeroAction();
        } else {
            $this->user->room = $room;
        }
        
        $this->user->save();
    }
    
    protected function calcUserPoints()
    {
        if ($this->user && !empty($this->user->username) && (int)$this->user->health_value > 0) {
            if ($this->user->points > 0) {
                $this->user->points--;
                $this->user->save();
            }
        }
    }
    
    private function createZeroAction()
    {
        $_action = new Actions();
        $_action->user_id = $this->user->user_id;
        $_action->level = $this->user->level;
        $_action->room = '00';
        $_action->status = 'point';
        $_action->save();
    }
    
    /**
     * @return mixed
     */
    private function setRefresh()
    {
        $userData = $this->getFormattedUserData();
        if (!empty($userData['username'])) {
            $html = $this->renderer->render($userData, 'rooms');
            $this->calcUserPoints();
            
            $response = [
                'status'  => 'success',
                'message' => 'Action successfully done',
                'board'   => $html,
                'user'    => $this->user,
            ];
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Empty ajax result',
            ];
        }
        
        $this->response->setJsonContent($response);
        
        return $this->response;
    }
    
    /**
     * @return mixed
     */
    private function setReset()
    {
        $user = Users::findFirst(['conditions' => 'user_id = ' . $this->user->user_id]);
        $actions = Actions::find(['conditions' => 'user_id = ' . $this->user->user_id]);
        foreach ($actions as $action) {
            $action->delete();
        }
        $user->delete();
        
        $this->response->setJsonContent(
            [
                'status'  => 'success',
                'message' => 'Game reseted',
            ]
        );
        
        return $this->response;
    }
    
    private function calcItem()
    {
        $this->user->health_value += 1;
    }
    
    private function calcPoint()
    {
        $this->user->points += 3;
    }
    
    private function calcMonster()
    {
        $monster = rand(1, 2);
        $hpDiff =
            $this->user->level * $monster >= $this->user->attack_value ?
                $this->user->level * $monster - $this->user->attack_value : 0;
        $this->user->health_value -= $hpDiff;
        $this->user->points += rand(1, $this->user->level);
    }
    
    private function calcBoss()
    {
        $boss = rand(2, 3);
        $hpDiff = $this->user->level * $boss >= $this->user->attack_value ?
            $this->user->level * $boss - $this->user->attack_value : 0;
        
        $this->user->health_value -= $hpDiff;
        $this->user->attack_value += rand(1 , 100) > (75 - $this->user->level / 10) ? 1 : 0;
        $this->user->boss_count += 1;
        $this->user->points += $boss;
    }
}
