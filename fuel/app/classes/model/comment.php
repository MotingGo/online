<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/30
 * Time: 5:21
 */

class Model_Comment extends \Orm\Model
{
    protected static $_table_name = 'blog_comments';

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
        'guest' => [
            'model_to' => '\Model_Guest',
            'key_to' => 'id',
            'key_from' => 'user_id',
        ],
        'parent_comment' => [
            'model_to' => '\Model_Comment',
            'key_to' => 'id',
            'key_from' => 'parent_id',
        ],
    ];

    protected static $_has_many = [
        'comments' => [
            'model_to' => '\Model_Comment',
            'key_to' => 'parent_id',
            'key_from' => 'id',
            'conditions' => [
                'order_by' => [
                    'display_at' => 'ASC'
                ],
                'where' => [
                    'is_deleted' => '0',
                ]
            ]
        ],
    ];

}