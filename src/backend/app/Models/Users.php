<?php

namespace maze\Models;

use Phalcon\Mvc\Model;

/**
 * Class Users
 */
class Users extends Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="user_id", type="integer", length=11, nullable=false)
     */
    public $user_id;
    /**
     *
     * @var string
     * @Column(column="session_id", type="string", length=32, nullable=false)
     */
    public $session_id;
    /**
     *
     * @var string
     * @Column(column="username", type="string", length=255, nullable=false)
     */
    public $username;
    /**
     *
     * @var string
     * @Column(column="room", type="string", length=2, nullable=false)
     */
    public $room;
    /**
     *
     * @var integer
     * @Column(column="level", type="integer", length=3, nullable=false)
     */
    public $level;
    /**
     *
     * @var integer
     * @Column(column="health_value", type="integer", length=3, nullable=false)
     */
    public $health_value;
    /**
     *
     * @var integer
     * @Column(column="attack_value", type="integer", length=11, nullable=false)
     */
    public $attack_value;
    /**
     *
     * @var string
     * @Column(column="start_dttm", type="string", nullable=false)
     */
    public $start_dttm;
    /**
     *
     * @var integer
     * @Column(column="boss_count", type="integer", length=11, nullable=true)
     */
    public $boss_count;
    /**
     *
     * @var integer
     * @Column(column="points", type="integer", length=11, nullable=true)
     */
    public $points;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema('maze');
        $this->setSource('users');
        $this->hasMany(
            'user_id',
            Actions::class,
            'user_id'
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }
}
