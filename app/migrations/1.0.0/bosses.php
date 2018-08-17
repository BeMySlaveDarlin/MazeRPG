<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BossesMigration_100
 */
class BossesMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('bosses', [
                'columns' => [
                    new Column(
                        'boss_id',
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
                            'after' => 'boss_id'
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
                        'base_health',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'base_attack',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'base_health'
                        ]
                    ),
                    new Column(
                        'icon',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "boss.png",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'base_attack'
                        ]
                    ),
                    new Column(
                        'avatar',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "boss_big.png",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'icon'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['boss_id'], 'PRIMARY'),
                    new Index('avatar', ['avatar'], null),
                    new Index('icon', ['icon'], null),
                    new Index('base_attack', ['base_attack'], null),
                    new Index('base_health', ['base_health'], null),
                    new Index('description', ['description'], null),
                    new Index('name', ['name'], null)
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
