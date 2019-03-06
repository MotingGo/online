<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 0:08
 */

namespace manager;

use \Auth\Auth;

class Controller_Note extends Controller_Home
{
    /**
     * 列表页面
     * @return \Fuel\Core\View
     */
    public function action_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('note/index');

        $query = \Model_Note::query()
            ->where([
                'is_deleted' => 0
            ])
            ->order_by(['display_at' => 'DESC']);

        if ($keyword = \Input::get('keyword')){
            $query->where([
                ['content','LIKE',"%{$keyword}%"],
            ]);
        }

        $view->notes = $query->get();

        // 设置最后一片文章的时间戳
        $view->end_display_at = $view->notes ? current($view->notes)->display_at : 0;

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

        return \View::forge('note/add');
    }

    /**
     * 编辑页面
     * @return mixed
     */
    public function action_edit($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('note/add');

        $view->note = \Model_Note::find($id);

        $view->note->content = str_replace(chr(10), '\\n', $view->note->content);

        return $view;
    }

    /**
     * 指定的文章 - 获取
     * @param int $id
     * @return array
     */
    public function get_item($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $note = \Model_Note::find($id);

        $this->result['data'] = [
            'id' => $note->id,
            'content' => $note->content,
            'display_at' => $note->display_at,
        ];

        return $this->result;
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

        $notes = \Model_Note::query()
            ->where([
                ['display_at', '>', $display_at]
            ])
            ->order_by([
                'display_at' => 'ASC'
            ])
            ->get();

        $items = [];
        foreach ($notes as $note){
            array_push($items, [
                'id' => $note->id,
                'content' => $note->content,
                'display_at' => $note->display_at,
            ]);
        }

        $this->result['data'] = $items;

        return $this->result;
    }

    /**
     * 笔记 - 添加
     * @return array
     * @throws \Exception
     */
    public function post_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $data = \Input::post();

        $note = \Model_Note::forge($data);

        $note->set([
            'user_id' => Auth::get_user_id()[1],
            'display_at' => time(),
        ]);

        $note->save();

        return $this->result;
    }

    /**
     * 笔记 - 修改
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function put_index($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $note = \Model_Note::find($id);

        $data = \Input::put();

        $note->set($data);

        $note->save();

        return $this->result;
    }

    /**
     * 笔记 - 删除
     * @return array
     * @throws \Exception
     */
    public function delete_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $id = \Input::delete('id');

        $note = \Model_Note::find($id);

        $note->is_deleted = 1;

        $note->save();

        return $this->result;
    }
}