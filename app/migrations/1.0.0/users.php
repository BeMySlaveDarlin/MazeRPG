<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsersMigration_100
 */
class UsersMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('users', [
                'columns' => [
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'session_id',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 32,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'session_id'
                        ]
                    ),
                    new Column(
                        'room',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'username'
                        ]
                    ),
                    new Column(
                        'level',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'room'
                        ]
                    ),
                    new Column(
                        'current_health',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "5",
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'level'
                        ]
                    ),
                    new Column(
                        'base_health',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "5",
                            'notNull' => true,
                            'size' => 3,
                            'after' => 'current_health'
                        ]
                    ),
                    new Column(
                        'current_attack',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'base_health'
                        ]
                    ),
                    new Column(
                        'base_attack',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'current_attack'
                        ]
                    ),
                    new Column(
                        'start_dttm',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'base_attack'
                        ]
                    ),
                    new Column(
                        'death_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'size' => 11,
                            'after' => 'start_dttm'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['user_id'], 'PRIMARY'),
                    new Index('session_id', ['session_id'], 'UNIQUE'),
                    new Index('username', ['username'], null),
                    new Index('room', ['room'], null),
                    new Index('current_health', ['current_health'], null),
                    new Index('base_health', ['base_health'], null),
                    new Index('level', ['level'], null),
                    new Index('death_count', ['death_count'], null),
                    new Index('current_attack', ['current_attack'], null),
                    new Index('base_attack', ['base_attack'], null),
                    new Index('start_dttm', ['start_dttm'], null)
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
