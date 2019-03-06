<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/11
 * Time: 15:11
 */

return array(
    '_root_'  => 'manager/home/main',  // The default route
    '_404_'   => 'home/index',    // The main 404 route
    'manager' => 'manager/home/main',
    'manager/logout' => 'manager/home/logout',
    'manager/main' => 'manager/home/main',
    'manager/article/(\d+)' => [
        ['GET', new \Fuel\Core\Route('manager/article/item/$1')],
        ['PUT', new \Fuel\Core\Route('manager/article/index/$1')],
    ],
    'manager/note/(\d+)' => [
        ['GET', new \Fuel\Core\Route('manager/note/item/$1')],
        ['PUT', new \Fuel\Core\Route('manager/note/index/$1')],
    ],
    'manager/message/(\d+)' => [
        ['GET', new \Fuel\Core\Route('manager/message/item/$1')],
        ['PUT', new \Fuel\Core\Route('manager/message/index/$1')],
    ],

);