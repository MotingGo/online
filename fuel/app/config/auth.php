<?php
/**
 * Created by PhpStorm.
 * User: moting
 * Date: 2017/6/24
 * Time: 11:05
 */

return array(
    // The drivers
    'driver' => 'Simpleauth',

    // Set to true to allow multiple logins
    'verify_multiple_logins' => true,

    // Use your own salt for security reasons
    'salt' => 'Th1s=mY0Wn_$@|+',

    'iterations'             => 10000,
);