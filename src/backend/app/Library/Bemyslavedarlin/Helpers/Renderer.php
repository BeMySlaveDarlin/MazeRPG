<?php

namespace Maze\Library\Bemyslavedarlin\Helpers;

use Maze\Models\Actions;
use Maze\Models\Users;
use Nubs\RandomNameGenerator\All as RNGenerator;
use Phalcon\Mvc\User\Plugin;

/**
 * Class Renderer
 *
 * @package Maze\Library\Bemyslavedarlin\Helpers
 */
class Renderer extends Plugin
{
    private $fRow = 7;
    private $fCol = 9;
    private $generator;
    private $user;
    private $character = true;

    /**
     * Renderer constructor.
     */
    public function __construct()
    {
        $session_id = $this->session->getId();
        $this->user = Users::findFirst(['conditions' => "session_id = '" . $session_id . "'"]);

        $this->generator = RNGenerator::create();
    }

    /**
     * @param array $data
     * @param string $type
     *
     * @return bool
     */
    public function render(array $data = [], string $type = 'status')
    {
        $method = 'render' . ucfirst($type);

        return method_exists($this, $method) ? self::$method($data) : false;
    }

    /**
     * @param $data
     *
     * @return string
     */
    private function renderPlayboard($data)
    {
        if (!empty($data['username'])) {
            $html = $this->renderRooms($data);
        } else {
            $html = $this->renderAuthForm();
        }

        return $html;
    }

    /**
     * @param $data
     *
     * @return string
     */
    private function renderRooms($data)
    {
        $hasActions = false;
        $charRoom = false;
        $html = [];
        for ($row = 0; $row <= $this->fRow; $row++) {
            for ($col = 0; $col <= $this->fCol; $col++) {
                $room = $row . $col;
                $character = $this->getCharacter($data, $room);
                $lastAction = $this->getLastAction($data['actions'], $room);
                $actions = $this->getRooms($data, $row, $col);
                $last = $this->getLastRoom($room);
                $content = $character ?: $lastAction ?: $actions ?: $last ?: '';

                $hasActions = $hasActions ?: $actions;
                if ($character) {
                    $charRoom = $room;
                }
                $html[$room] = $this->renderDiv(
                    [
                        'class' => 'card ',
                        'data-room' => $room,
                    ],
                    $content
                );
            }
        }

        if (!$hasActions) {
            $this->user->health_value = 0;
            $this->user->update();

            $content = $this->getCharacter($data, $charRoom, true);
            $html[$charRoom] = $this->renderDiv(
                [
                    'class' => 'card ',
                    'data-room' => $room,
                ],
                $content
            );
        }

        return implode('', $html);
    }

    /**
     * @param        $data
     * @param string $room
     * @param bool $dead
     *
     * @return bool|string
     */
    private function getCharacter($data, $room = '01', bool $dead = false)
    {
        $character = $data['user_id'] % 2 == 0 ? '1' : ($data['user_id'] % 3 == 0 ? '2' : '3');
        $character = $data['health_value'] > 0 ? $character : 'dead';
        $character = $dead ? 'dead' : $character;
        if ($character == 'dead') {
            $this->character = false;
        }
        $title = $data['health_value'] > 0 && !$dead ? 'You current location' : 'You are dead. Reset the game.';
        $character = $this->renderDiv(
            [
                'class' => 'action',
                'title' => $title,
            ],
            '<img height="100%"  src="/img/characters/' . $character . '.gif" />'
        );

        return $room == $data['room'] ?
            $character : false;
    }

    /**
     * @param array $attributes
     * @param string $content
     *
     * @return string
     */
    private function renderDiv(array $attributes = [], string $content = null)
    {
        $selectors = [];
        foreach ($attributes as $attribute => $value) {
            $selectors[] = $attribute . '="' . $value . '"';
        }

        $div = '<div ' . implode(' ', $selectors) . '>';
        $div .= $content;
        $div .= '</div>';

        return $div;
    }

    /**
     * @param $actions
     * @param string $room
     *
     * @return bool|string
     * @throws \Exception
     */
    private function getLastAction($actions, $room = '01')
    {
        $monster = rand(1, 2);
        $boss = rand(2, 3);
        $level = $this->user->level;

        $bonus = [
            'item' => '+1 Health bonus',
            'point' => '+3 Points bonus',
            'monster' => "+$monster Points bonus",
            'boss' => "+$boss  Points bonus | +1 Defence (acc 50-75%)",
        ];

        return !empty($actions[$room]) ?
            $this->renderDiv(
                [
                    'class' => 'action',
                    'title' => $bonus[$actions[$room]['status']],
                ],
                $this->renderDiv(
                    ['class' => 'action-done action-' . $actions[$room]['status']],
                    ''
                )
            ) : false;
    }

    /**
     * @param $data
     * @param $row
     * @param $col
     *
     * @return bool|string
     */
    private function getRooms($data, $row, $col)
    {
        $room = $row . $col;
        if (empty($data['actions'][$room]) && $data['health_value'] > 0) {
            $rooms = [
                $this->getLeftRoom($data) => 'left',
                $this->getRightRoom($data) => 'right',
                $this->getTopRoom($data, $row) => 'top',
                $this->getBottomRoom($data, $row) => 'bottom',
            ];

            return !empty($rooms[$room]) && ($row <= 7 && $col <= 9) ?
                $this->renderAction($rooms[$room]) : false;
        }

        return false;
    }

    /**
     * @param $data
     *
     * @return null|string
     */
    private function getLeftRoom($data)
    {
        $row = $data['room'][0];

        return $this->getRoom($data['room'] - 1, $row);
    }

    /**
     * @param string $possible
     * @param        $row
     *
     * @return null|string
     */
    private function getRoom($possible = '00', $row)
    {
        $rowStart = $row * 10;
        $rowEnd = ($row * 10) + 9;

        return (
            $possible >= $rowStart
            && $possible <= $rowEnd
        ) ? sprintf("%02d", $possible) : null;
    }

    /**
     * @param $data
     *
     * @return null|string
     */
    private function getRightRoom($data)
    {
        $row = $data['room'][0];

        return $this->getRoom($data['room'] + 1, $row);
    }

    /**
     * @param $data
     * @param $row
     *
     * @return null
     */
    private function getTopRoom($data, $row)
    {
        return $this->getRoom($data['room'] - 10, $row);
    }

    /**
     * @param $data
     * @param $row
     *
     * @return null
     */
    private function getBottomRoom($data, $row)
    {
        return $this->getRoom($data['room'] + 10, $row);
    }

    /**
     * @param string $direction
     *
     * @return string
     */
    private function renderAction($direction = 'left')
    {
        $action = $this->getAction();
        $title = $action == 'item' ? '+1 Health bonus' : '+3 Points bonus';

        $isEnemy = in_array(
            $action,
            [
                'monster',
                'boss',
            ]
        );
        if ($isEnemy) {
            $title = $action == 'boss' ? '2 to 3 Points bonus' : '1 to 2 Points bonus';
        }

        return $this->renderDiv(
            ['class' => 'action'],
            $this->renderDiv(
                [
                    'class' => 'action-active action-' . $action,
                    'title' => $title,
                    'action' => $action,
                    'direction' => $direction,
                ], ''
            )
        );
    }

    /**
     * @return mixed
     */
    private function getAction()
    {
        $actions = [
            'item' => '60',
            'monster' => '60',
            'point' => '15',
            'boss' => '15',
        ];

        $newActions = [];
        foreach ($actions as $action => $value) {
            $newActions = array_merge(
                $newActions,
                array_fill(
                    0,
                    $value,
                    $action
                )
            );
        }

        return $newActions[array_rand($newActions)];
    }

    /**
     * @param string $room
     *
     * @return string
     */
    private function getLastRoom($room = '00')
    {
        return $room == '79' ? $this->renderDiv(
            ['class' => 'action'],
            $this->renderDiv(
                [
                    'class' => 'last-room',
                    'title' => 'Last room of this level',
                ],
                ''
            )
        ) : false;
    }

    /**
     * @return string
     */
    private function renderAuthForm()
    {
        return $this->renderDiv(
            ['class' => 'auth-board'],
            implode(
                "",
                [
                    '<form class="auth-form" title="Type down you preferred username" method="POST" action="auth">',
                    '<input type="hidden" name="mode" value="setUsername">',
                    '<input type="text" class="auth-input-username" name="username" value="" placeholder="Enter Name">',
                    '<input type="submit" class="auth-input-submit" value="OK">',
                    '</form>',
                ]
            )
        );
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function renderStatus($data)
    {
        $html['username'] = $this->renderDiv(
            [
                'class' => 'text-bar right-border',
                'id' => 'username',
                'title' => 'Username',
            ],
            !empty($data['username']) ? $data['username'] : '- NONAME -'
        );
        $html['level'] = $this->renderDiv(
            [
                'class' => 'text-bar',
                'id' => 'level',
                'title' => 'Level',
            ],
            'LVL: ' . $data['level']
        );
        $html['health'] = $this->renderDiv(
            [
                'class' => 'health-bar',
                'id' => 'health',
                'title' => 'Health Points',
            ],
            $data['health_value']
        );
        $html['attack'] = $this->renderDiv(
            [
                'class' => 'attack-bar',
                'id' => 'attack',
                'title' => 'Defence Power',
            ],
            $data['attack_value']
        );
        $html['boss'] = $this->renderDiv(
            [
                'class' => 'boss-bar',
                'id' => 'boss',
                'title' => 'Bosses Killed',
            ],
            (int)$data['boss_count']
        );
        $html['points'] = $this->renderDiv(
            [
                'class' => 'points-bar',
                'id' => 'points',
                'title' => 'Ppcc Points',
            ],
            (int)$data['points']
        );
        $html['room'] = $this->renderDiv(
            [
                'class' => 'text-bar',
                'id' => 'room',
                'title' => 'Current level room',
            ],
            'ROOM: ' . $data['room']
        );

        return $html;
    }
}
