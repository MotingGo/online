<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/21
 * Time: 1:14
 */

class Model_Category extends \Orm\Model
{
    protected static $_table_name = 'blog_categories';

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
}