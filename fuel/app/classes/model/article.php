<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/21
 * Time: 0:44
 */

class Model_Article extends \Orm\Model
{
    protected static $_table_name = 'blog_articles';

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

    protected static $_has_many = [
        'attachments' => [
            'model_to' => '\Model_ArticleAttachment',
            'key_to' => 'article_id',
            'key_from' => 'id',
        ],
    ];

    protected static $_has_one = [
        'thumbnail' => [
            'model_to' => '\Model_Attachment',
            'key_to' => 'id',
            'key_from' => 'thumbnail_id',
        ],
        'label' => [
            'model_to' => '\Model_Category',
            'key_to' => 'id',
            'key_from' => 'label_id',
        ]
    ];
}