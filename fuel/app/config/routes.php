<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_404_'   => 'home/index',    // The main 404 route

    'manager' => 'home/manager',
    'index' => 'home/index',
    'article' => 'home/article',
    'article/(\d+)' => 'home/article_detail/$1',
    'timeline' => 'home/timeline',
    'about' => 'home/about',

    'login' => 'home/login',
    'register' => 'home/register',

);
