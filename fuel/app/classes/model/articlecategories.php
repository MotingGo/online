<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/21
 * Time: 1:15
 */

class Model_ArticleCategories extends \Orm\Model
{
    protected static $_table_name = 'blog_articles_categories';

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
        'article' => [
            'model_to' => '\Model_Article',
            'key_to' => 'id',
            'key_from' => 'article_id',
        ],
        'category' => [
            'model_to' => '\Model_Category',
            'key_to' => 'id',
            'key_from' => 'category_id',
        ],
    ];
}