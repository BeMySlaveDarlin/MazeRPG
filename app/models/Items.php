<?php

use Phalcon\Mvc\Model;

/**
 * Class Items
 */
class Items extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="item_id", type="integer", length=11, nullable=false)
     */
    public $item_id;

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
     * @var string
     * @Column(column="bonus", type="string", nullable=false)
     */
    public $bonus;

    /**
     *
     * @var integer
     * @Column(column="value", type="integer", length=3, nullable=false)
     */
    public $value;

    /**
     *
     * @var string
     * @Column(column="icon", type="string", length=255, nullable=false)
     */
    public $icon;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("maze");
        $this->setSource("items");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'items';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Items[]|Items|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Items|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
