<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/28
 * Time: 20:45
 */

class Model_Guest extends \Orm\Model
{
    protected static $_table_name = 'guest';

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

    protected static $_has_one = [
        'avatar' => [
            'model_to' => '\Model_Attachment',
            'key_to' => 'id',
            'key_from' => 'avatar_id',
        ],
    ];

    public function refresh_login(){

    }
}