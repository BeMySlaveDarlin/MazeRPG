<?php

use Phalcon\Mvc\Model;

/**
 * Class Bosses
 */
class Bosses extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="boss_id", type="integer", length=11, nullable=false)
     */
    public $boss_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=64, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="description", type="string", length=128, nullable=false)
     */
    public $description;

    /**
     *
     * @var integer
     * @Column(column="base_health", type="integer", length=3, nullable=false)
     */
    public $base_health;

    /**
     *
     * @var integer
     * @Column(column="base_attack", type="integer", length=3, nullable=false)
     */
    public $base_attack;

    /**
     *
     * @var string
     * @Column(column="icon", type="string", length=255, nullable=false)
     */
    public $icon;

    /**
     *
     * @var string
     * @Column(column="avatar", type="string", length=255, nullable=false)
     */
    public $avatar;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("maze");
        $this->setSource("bosses");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'bosses';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bosses[]|Bosses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bosses|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
