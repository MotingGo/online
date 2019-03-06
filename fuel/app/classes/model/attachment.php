<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/21
 * Time: 0:43
 */

class Model_Attachment extends \Orm\Model
{
    protected static $_table_name = 'attachments';

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
        'people' => [
            'model_to' => '\user\Model_People',
            'key_to' => 'user_id',
            'key_from' => 'user_id',
        ],
    ];

}