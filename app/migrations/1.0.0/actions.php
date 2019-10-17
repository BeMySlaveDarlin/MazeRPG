<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ActionsMigration_100
 */
class ActionsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable(
            'actions', [
                'columns' => [
                    new Column(
                        'action_id',
                        [
                            'type'          => Column::TYPE_INTEGER,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'size'          => 11,
                            'first'         => true,
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size'    => 11,
                            'after'   => 'action_id',
                        ]
                    ),
                    new Column(
                        'level',
                        [
                            'type'    => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size'    => 11,
                            'after'   => 'user_id',
                        ]
                    ),
                    new Column(
                        'room',
                        [
                            'type'    => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size'    => 2,
                            'after'   => 'level',
                        ]
                    ),
                    new Column(
                        'status',
                        [
                            'type'    => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size'    => 1,
                            'after'   => 'room',
                        ]
                    ),
                    new Column(
                        'dttm',
                        [
                            'type'    => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size'    => 1,
                            'after'   => 'status',
                        ]
                    ),
                ],
                'indexes' => [
                    new Index('PRIMARY', ['action_id'], 'PRIMARY'),
                    new Index('user_id', ['user_id'], null),
                    new Index('level', ['level'], null),
                    new Index('room', ['room'], null),
                    new Index('status', ['status'], null),
                    new Index('dttm', ['dttm'], null),
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
