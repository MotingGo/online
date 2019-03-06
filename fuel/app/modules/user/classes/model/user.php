<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/10
 * Time: 15:11
 */
namespace user;

use \Auth\Model\Auth_User;
use \Auth\Auth;
use \Auth\SimpleUserUpdateException;

class Model_User extends Auth_User
{
    protected static $_table_name = 'users_users';

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
        'people' => [
            'model_to' => '\user\Model_People',
            'key_to' => 'user_id',
            'key_from' => 'id',
        ],
        'permission' => [
            'model_to' => '\user\Model_Permission',
            'key_to' => 'user_id',
            'key_from' => 'id',
        ],
    ];

    protected static $_temporal = array(
        'mysql_timestamp' => false,
    );

    /**
     * 注册用户
     * @param $data
     *      username    账号名称
     *      password    密码
     *      email       邮箱
     *      nickname    昵称
     *      truename    真实姓名
     *      age         年龄
     *      gender      性别
     *      birth       生日
     *      avatar      头像
     *      career      职业
     *      summary     个人介绍
     *      explanation 个人说明
     *      is_manager  管理员标识
     *      is_admin    超级管理员标识
     *      is_backlist 黑名单标识
     *      is_article  管理文章标识
     *      is_resource 管理资源标识
     *      is_note     管理笔记标识
     *      is_user     用户标识
     *      is_login    登陆标识
     * @param $result
     * @return bool
     * @throws \Exception
     * @throws \FuelException
     */
    public static function register_user($data, &$result){

        static::check_user_data_param($data);

        try{
            // create a new user
            if ( ! $user_id =  Auth::create_user(
                $data['username'],
                $data['password'],
                $data['email'],
                1,
                [] ) ){

                $result['status'] = 'err';
                $result['code'] = -1;
                $result['msg'] = '创建失败';
            }

            $current_user = static::find($user_id);

            $current_user->init_user($data);

            $current_user->save();
            return true;

        } catch (SimpleUserUpdateException $ex){

            $result['status'] = 'err';
            $result['msg'] = $ex->getMessage();
            $result['code'] = $ex->getCode();

            return false;
        }
    }

    private static function check_user_data_param(&$data){
        $is_must = [
            'username' => '',
            'password' => '',
            'email' => '',
            'nickname' => '',
            'truename' => '',
            'age' => '0',
            'gender' => '',
            'birth' => '',
            'avatar' => '',
            'career' => '',
            'summary' => '',
            'explanation' => '',
            'is_manager' => '0',
            'is_admin' => '0',
            'is_backlist' => '0',
            'is_article' => '0',
            'is_resource' => '0',
            'is_note' => '0',
            'is_user' => '0',
        ];

        foreach ($is_must as $key => $value){
            if ( ! isset($data[$key])){
                $data[$key] = $value;
            }
        }
    }

    public function init_user($data){

        if ( ! $this->people ){
            $this->people = Model_People::forge($data);
        }

        if ( ! $this->permission ){
            $this->permission = Model_Permission::forge($data);
        }
    }
}