<?php

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
     * @var integer
     * @Column(column="room", type="integer", length=11, nullable=false)
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
     * @Column(column="current_health", type="integer", length=3, nullable=false)
     */
    public $current_health;

    /**
     *
     * @var integer
     * @Column(column="base_health", type="integer", length=3, nullable=false)
     */
    public $base_health;

    /**
     *
     * @var integer
     * @Column(column="current_attack", type="integer", length=11, nullable=false)
     */
    public $current_attack;

    /**
     *
     * @var integer
     * @Column(column="base_attack", type="integer", length=11, nullable=false)
     */
    public $base_attack;

    /**
     *
     * @var string
     * @Column(column="start_dttm", type="string", nullable=false)
     */
    public $start_dttm;

    /**
     *
     * @var integer
     * @Column(column="death_count", type="integer", length=11, nullable=true)
     */
    public $death_count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("maze");
        $this->setSource("users");
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

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
