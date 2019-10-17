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
        $this->morphTable(
            'users', [
                'columns' => [
                    new Column(
                        'user_id',
                        [
                            'type'          => Column::TYPE_INTEGER,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'size'          => 11,
                            'first'         => true,
                        ]
                    ),
                    new Column(
                        'session_id',
                        [
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 32,
                            'after'   => 'user_id',
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 255,
                            'after'   => 'session_id',
                        ]
                    ),
                    new Column(
                        'room',
                        [
                            'type'    => Column::TYPE_CHAR,
                            'default' => "00",
                            'notNull' => true,
                            'size'    => 2,
                            'after'   => 'username',
                        ]
                    ),
                    new Column(
                        'level',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size'    => 3,
                            'after'   => 'room',
                        ]
                    ),
                    new Column(
                        'health_value',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size'    => 11,
                            'after'   => 'level',
                        ]
                    ),
                    new Column(
                        'attack_value',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size'    => 11,
                            'after'   => 'health_value',
                        ]
                    ),
                    new Column(
                        'start_dttm',
                        [
                            'type'    => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size'    => 1,
                            'after'   => 'attack_value',
                        ]
                    ),
                    new Column(
                        'boss_count',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'default' => "0",
                            'size'    => 11,
                            'after'   => 'start_dttm',
                        ]
                    ),
                    new Column(
                        'pionts',
                        [
                            'type'  => Column::TYPE_INTEGER,
                            'size'  => 11,
                            'after' => 'boss_count',
                        ]
                    ),
                ],
                'indexes' => [
                    new Index('PRIMARY', ['user_id'], 'PRIMARY'),
                    new Index('session_id', ['session_id'], 'UNIQUE'),
                    new Index('username', ['username'], null),
                    new Index('level', ['level'], null),
                    new Index('room', ['room'], null),
                    new Index('health_value', ['health_value'], null),
                    new Index('attack_value', ['attack_value'], null),
                    new Index('start_dttm', ['start_dttm'], null),
                    new Index('points', ['points'], null),
                ],
                'options' => [
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '1',
                    'ENGINE'          => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci',
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
