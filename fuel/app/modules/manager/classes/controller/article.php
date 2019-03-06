<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/25
 * Time: 16:34
 */

namespace manager;


use Auth\Auth;

class Controller_Article extends Controller_Home
{
    /**
     * 指定的文章 - 获取
     * @param int $id
     * @return array
     */
    public function get_item($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $article = \Model_Article::find($id);

        $this->result['data'] = [
            'thumbnail' => $article->thumbnail->url,
            'title' => $article->title,
            'summary' => $article->summary,
        ];

        return $this->result;
    }

    /**
     * 文章 - 添加
     * @return array
     * @throws \Exception
     */
    public function post_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $data = \Input::post();

        $article = \Model_Article::forge($data);
        $article->set([
            'user_id' => Auth::get_user_id()[1],
            'display_at' => time(),
        ]);

        $attachment = \Model_Attachment::find($data['thumbnail_id']);
        // 处理图片宽高问题
//        \tool\Common::cut_picture($attachment->path, $attachment->type, $attachment->file);

        $article->save();

        return $this->result;
    }

    /**
     * 文章 - 修改
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function put_index($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $article = \Model_Article::find($id);

        $data = \Input::put();

        $article->set($data);

        $article->save();

        return $this->result = [
            'status' => 'succ',
            'errcode' => 0,
            'msg' => '',
        ];
    }

    /**
     * 文章 - 删除
     * @return array
     * @throws \Exception
     */
    public function delete_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $id = \Input::delete('id');

        $article = \Model_Article::find($id);

        $article->is_deleted = 1;

        $article->save();

        return $this->result = [
            'status' => 'succ',
            'errcode' => 0,
            'msg' => '',
        ];
    }

    /**
     * 列表页面
     * @return \Fuel\Core\View
     */
    public function action_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('article/index');

        $query = \Model_Article::query()
            ->where([
                'is_deleted' => 0,
            ])
            ->order_by([
                'created_at' => 'DESC'
            ]);

        if ($keyword = \Input::get('keyword')){
            $query->where([
                ['title','LIKE',"%{$keyword}%"],
                ['summary','LIKE',"%{$keyword}%"],
                ['content','LIKE',"%{$keyword}%"],
            ]);
        }

        $view->articles = $query->get();

        $view->end_display_at = $view->articles ? current($view->articles)->display_at : 0;

        $view->keyword = $keyword;

        return $view;
    }

    /**
     * 添加页面
     * @return mixed
     */
    public function action_add(){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('article/add');

        return $view;
    }

    /**
     * 编辑页面
     * @param int $id
     * @return mixed
     */
    public function action_edit($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('article/add');

        $view->article = \Model_Article::find($id);

        $view->article->summary = str_replace(chr(10), '\\n', $view->article->summary);

        return $view;
    }



    /**
     * 最新的文章 - 获取
     * @return array
     */
    public function get_new(){

        if ( ! $this->flag){
            return $this->result;
        }

        $display_at = \Input::get('display_at', 0);

        $articles = \Model_Article::query()
            ->where([
                ['display_at', '>', $display_at]
            ])
            ->order_by([
                'display_at' => 'ASC'
            ])
            ->get();

        $items = [];
        foreach ($articles as $article){
            array_push($items, [
                'id' => $article->id,
                'title' => $article->title,
                'summary' => $article->summary,
                'thumbnail' => $article->thumbnail->url,
                'display' => $article->display_at,
            ]);
        }

        $this->result['data'] = $items;

        return $this->result;
    }


}