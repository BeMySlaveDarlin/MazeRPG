<?php

use Phalcon\Mvc\Model;

/**
 * Class Actions
 */
class Actions extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="action_id", type="integer", length=11, nullable=false)
     */
    public $action_id;

    /**
     *
     * @var integer
     * @Column(column="user_id", type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(column="level", type="integer", length=11, nullable=false)
     */
    public $level;

    /**
     *
     * @var integer
     * @Column(column="step", type="integer", length=11, nullable=false)
     */
    public $step;

    /**
     *
     * @var integer
     * @Column(column="room", type="integer", length=11, nullable=false)
     */
    public $room;

    /**
     *
     * @var integer
     * @Column(column="boss_id", type="integer", length=11, nullable=true)
     */
    public $boss_id;

    /**
     *
     * @var integer
     * @Column(column="item_id", type="integer", length=11, nullable=true)
     */
    public $item_id;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;

    /**
     *
     * @var string
     * @Column(column="dttm", type="string", nullable=false)
     */
    public $dttm;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("maze");
        $this->setSource("actions");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'actions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actions[]|Actions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
