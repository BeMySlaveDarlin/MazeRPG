<?php

namespace maze\Models;

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
     * @var string
     * @Column(column="room", type="string", length=2, nullable=false)
     */
    public $room;
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
        $this->setSchema('maze');
        $this->setSource('actions');
        $this->hasOne(
            'user_id',
            Users::class,
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
        return 'actions';
    }
}
