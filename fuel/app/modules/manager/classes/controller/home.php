<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/11
 * Time: 0:22
 */

namespace manager;

use Fuel\Core\Input;
use \Fuel\Core\View;
use \Auth\Auth;

class Controller_Home extends \Controller_Home
{
    /**
     * 执行标记  before -> method -> a fter
     * @var bool
     */
    protected $flag = true;
    /**
     * 前置-检查是否登陆
     *
     * @return array|null
     */
    public function before()
    {
        parent::before();

        // 当前控制器的鉴权
        if ( ! Auth::check() )
        {
            $this->flag = false;

            if ( 'GET' ==  Input::method()){

                $this->result = parent::action_manager();
            } else {

                return $this->result = [
                    'status' => 'err',
                    'code' => 0,
                    'msg' => '暂无权限',
                ];
            }
        }
        return null;
    }

    /**
     * 登出
     * @return array
     */
    public function put_logout()
    {
        if ( ! $this->flag){
            return $this->result;
        }

        $status = Input::put('status');

        if ( $status == 1 ){

            Auth::logout();
        }

        return $this->result;
    }

    /**
     * 主页
     * @return View
     */
    public function action_main()
    {
        if ( ! $this->flag){
            return $this->result;
        }

        $view = View::forge('home/main');

        $view->comment_count = \Model_Comment::query()->count();

        $view->article_count = \Model_Article::query()->count();

        $view->note_count = \Model_Note::query()->count();

        $view->datetime = date('Y年 m月 d日 H:i:s', time());

        $view->real_ip = \Input::real_ip();

        return $view;
    }
}