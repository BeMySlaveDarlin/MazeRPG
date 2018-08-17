<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ItemsMigration_100
 */
class ItemsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('items', [
                'columns' => [
                    new Column(
                        'item_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 64,
                            'after' => 'item_id'
                        ]
                    ),
                    new Column(
                        'description',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 128,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'bonus',
                        [
                            'type' => Column::TYPE_CHAR,
                            'default' => "health",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'value',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'bonus'
                        ]
                    ),
                    new Column(
                        'icon',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "item.png",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'value'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['item_id'], 'PRIMARY'),
                    new Index('name', ['name'], null),
                    new Index('description', ['description'], null),
                    new Index('bonus', ['bonus'], null),
                    new Index('value', ['value'], null),
                    new Index('icon', ['icon'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
