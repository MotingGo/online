<?php

/**
 * Created by PhpStorm.
 * User: moting
 * Date: 2017/6/12
 * Time: 15:46
 */

use \Fuel\Core\View;
use \Fuel\Core\Controller;
use \Fuel\Core\Input;
use \Auth\Auth;
use \Auth\SimpleUserUpdateException;


class Controller_Home extends Controller
{
    public function before()
    {
        parent::before();
    }

    protected $result = [
        'status' => 'succ',
        'code' => 0,
        'msg' => '',
    ];

    /**
     * 首页
     * @return View
     */
    public function action_index()
    {
        // 获取最新发布的文章
        $articles = Model_Article::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by([
                'display_at' => 'DESC'
            ])
            ->limit(10)
            ->get();

        // 热文排行
        $hot_articles = Model_Article::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by([
                'reader_num' => 'DESC'
            ])
            ->limit(10)
            ->get();

        // 访客获取
        $guests = Model_Guest::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by([
                'created_at' => 'DESC'
            ])
            ->get();

        $view = View::forge('home/index');
        $view->articles = $articles;
        $view->guests = $guests;
        $view->hot_articles = $hot_articles;

        return $view;
    }

    /**
     * 文章列表
     * @return View
     *
     */
    public function action_article(){

        $articles = Model_Article::query()
            ->where([
                'is_deleted' => 0,
            ])
            ->order_by([
                'created_at' => 'DESC'
            ])
            ->get();

        // 热文排行
        $hot_articles = Model_Article::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by([
                'reader_num' => 'DESC'
            ])
            ->limit(10)
            ->get();

        $view = View::forge('home/article');

        $view->articles = $articles;
        $view->hot_articles = $hot_articles;

        return $view;
    }

    /**
     * 时间轴
     * @return View
     */
    public function action_timeline(){

        $view = View::forge('home/timeline');

        $view->notes = Model_Note::query()
            ->where([
                'is_deleted' => 0
            ])
            ->get();

        return $view;
    }

    /**
     * 留言墙
     * @return View
     */
    public function action_about(){

        $comments = Model_Comment::query()
            ->where([
                'is_deleted' => 0,
                'parent_id' => 0,
                'is_display' => 0,
            ])
            ->order_by([
                'display_at' => 'DESC'
            ])
            ->get();

        $view = View::forge('home/about');

        $view->comments = $comments;

        return $view;
    }

    /**
     * 文章详情
     * @param $id
     * @return View
     */
    public function action_article_detail($id)
    {
        $article = \Model_Article::find($id);

        // 自动增加阅读人数
        $article->reader_num++;

        $article->save();
        // 热文排行
        $hot_articles = Model_Article::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by([
                'reader_num' => 'DESC'
            ])
            ->limit(10)
            ->get();

        $view = View::forge('home/article/detail');

        $view->article = $article;
        $view->hot_articles = $hot_articles;

        return $view;
    }

    /**
     * 管理页面
     * @return View
     */
    public function action_manager(){

        $view = View::forge('home/manager');

        return $view;
    }

    /**
     * 接口-登陆
     * @return array
     */
    public function post_login(){

        $password = Input::post('password');
        $username = Input::post('username');
        $email = Input::post('email');

        if ( ! Auth::login($username ? $username : $email, $password))
        {
            $this->result['status'] = 'err';
            $this->result['msg'] = '登陆失败';
            $this->result['code'] = 1;
        }

        return $this->result;
    }

    public function after($response)
    {
        // If the response is an array
        if (is_array($response))
        {
            // set the response
            $response = \Response::forge(json_encode($response), $this->response_status, ['Content-Type' => 'application/json']);
        }

        return parent::after($response);
    }
}