<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/10
 * Time: 15:55
 */

namespace user;

use \Orm\Model;
class Model_Permission extends Model
{
    protected static $_table_name = 'users_permissions';

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