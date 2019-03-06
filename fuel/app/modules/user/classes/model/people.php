<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/18
 * Time: 2:12
 */

namespace user;


use Orm\Model;

class Model_People extends Model
{
    protected static $_table_name = 'users_extends';

    protected static $_primary_key = array('id');

    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'property' => 'created_at',
            'mysql_timestamp' => false
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'property' => 'updated_at',
            'mysql_timestamp' => false
        )
    );

    protected static $_belongs_to = [
        'user' => [
            'model_to' => '\user\Model_User',
            'key_to' => 'id',
            'key_from' => 'user_id',
        ],
        'permission' => [
            'model_to' => '\user\Model_Permission',
            'key_to' => 'id',
            'key_from' => 'user_id',
        ]
    ];
}